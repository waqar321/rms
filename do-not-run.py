import pandas as pd
from datetime import datetime, timedelta
from urllib.parse import quote_plus
import sqlalchemy
from sqlalchemy.exc import OperationalError
from concurrent.futures import ThreadPoolExecutor
import time

# Connect to the MySQL database (lcs_mis)
password_lcs_mis = 'Le0p@nline2007'
encoded_password_lcs_mis = quote_plus(password_lcs_mis)
engine_lcs_mis = sqlalchemy.create_engine(
    f'mysql+pymysql://root:{encoded_password_lcs_mis}@172.16.0.7:3306/lcs_mis',
    pool_recycle=3600,
    pool_timeout=3000,
    connect_args={'connect_timeout': 3000}
)

# Connect to the MySQL database (lcs_db)
password_lcs_db = 'r@sik@123'
encoded_password_lcs_db = quote_plus(password_lcs_db)
engine_lcs_db = sqlalchemy.create_engine(
    f'mysql+pymysql://sajid:{encoded_password_lcs_db}@172.16.0.18:3306/lcs_db',
    pool_recycle=3600,
    pool_timeout=3000,
    connect_args={'connect_timeout': 3000}
)

# Connect to the SQL Server database
password_sql_server = 'PowerBI@22+-*'
username_sql_server = 'sa'
server_sql_server = '172.16.0.23'
database_sql_server = 'leopards_warehouse'
encoded_password_sql_server = quote_plus(password_sql_server)
connection_str_sql_server = f"mssql+pyodbc://{username_sql_server}:{encoded_password_sql_server}@{server_sql_server}/{database_sql_server}?driver=ODBC+Driver+17+for+SQL+Server"
engine_sql_server = sqlalchemy.create_engine(connection_str_sql_server)

# Get the latest DateTo from lss_tbl_sync_settings
table_name = "Arrival"
query_date_to = f"SELECT DateTo FROM lcs_mis.lss_tbl_sync_settings WHERE TableName LIKE '{table_name}' ORDER BY DateTo DESC LIMIT 1;"

try:
    with engine_lcs_mis.connect() as connection_lcs_mis:
        result_date_to = connection_lcs_mis.execute(query_date_to)
        date_from_value = result_date_to.scalar()  # Assuming DateTo is a single value

except Exception as e:
    print(f"Error retrieving DateTo: {e}")
    date_from_value = None

# Get the current time
current_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

# Execute the query on lcs_db
query_select = "SELECT * FROM lcs_db.arival WHERE SysDate_Time BETWEEN %s AND %s;"
params_select = (date_from_value - timedelta(minutes=0), current_time)

try:
    with engine_lcs_db.connect() as connection_lcs_db:
        df = pd.read_sql(query_select, connection_lcs_db, params=params_select)
        print(len(df))

except Exception as e:
    print(f"Error executing SELECT query: {e}")
    df = pd.DataFrame()

# Handle the case where df is empty
if not df.empty:
    try:
        # Function to insert a chunk into SQL Server
        def insert_chunk(chunk):
            try:
                with engine_sql_server.connect() as connection:
                    chunk.to_sql(name='arival', con=connection, if_exists='append', index=False)
                print("Successfully inserted chunk.")
            except OperationalError as e:
                print(f"Error inserting chunk: {e}")
                print("Attempting to reconnect...")
                # Reconnect logic here
                for retry in range(3):
                    try:
                        # Re-establish the connection
                        connection = engine_sql_server.connect()
                        # Retry inserting the chunk
                        chunk.to_sql(name='arival', con=connection, if_exists='append', index=False)
                        connection.close()
                        print("Reconnected and successfully inserted.")
                        break
                    except OperationalError as reconnection_error:
                        print(f"Reconnection attempt {retry + 1} failed: {reconnection_error}")
                        time.sleep(5)  # Wait for 5 seconds before the next attempt

        # Split the DataFrame into chunks
        batch_size = 1000  # Adjust as needed
        chunks = [df[i:i + batch_size] for i in range(0, len(df), batch_size)]

        # Use ThreadPoolExecutor for parallel processing
        with ThreadPoolExecutor(max_workers=4) as executor:
            executor.map(insert_chunk, chunks)

        # Insert into lss_tbl_sync_settings
        with engine_lcs_mis.connect() as connection_lcs_mis:
            # Reconnect logic for lss_tbl_sync_settings
            for retry in range(3):
                try:
                    min_sysdatetime = df['SysDate_Time'].min()
                    max_sysdatetime=df["SysDate_Time"].max()
                    num_rows = len(df)
                    status = "Success"
                    query_insert_both = f"INSERT INTO lcs_mis.lss_tbl_sync_settings (DateTo, DateFrom, RecordCount, Status, TableName) VALUES ('{max_sysdatetime}', '{min_sysdatetime}', '{num_rows}', '{status}', '{table_name}');"
                    connection_lcs_mis.execute(query_insert_both)
                    connection_lcs_mis.close()
                    print("Reconnected and successfully inserted into lss_tbl_sync_settings.")
                    break
                except OperationalError as reconnection_error:
                    print(f"Reconnection attempt {retry + 1} failed: {reconnection_error}")
                    time.sleep(5)  # Wait for 5 seconds before the next attempt

        print("Succeeded")

    except Exception as e:
        print(f"Error executing INSERT query: {e}")
        print("Failed to insert data into SQL Server.")
else:
    print("No data found in the arival table.")