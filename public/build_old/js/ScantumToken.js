const ID_TOKEN_KEY = "id_token_admin";

/**
 * @description get token form localStorage
 */
const getToken = () => {
    return window.localStorage.getItem(ID_TOKEN_KEY);
};

/**
 * @description save token into localStorage
 * @param token: string
 */
const saveToken = (token) => {
    window.localStorage.setItem(ID_TOKEN_KEY, token);
};

/**
 * @description remove token form localStorage
 */
const destroyToken = () => {
    window.localStorage.removeItem(ID_TOKEN_KEY);
};

const sendRequestWithToken = (url, method = "GET", data = null) => {
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        };
        $.ajax({
            url: url,
            method: method,
            data:data,
            headers: headers,
            dataType: 'json',
              beforeSend: function(){

              },
              success: function(data) {
                return data;
              },
             error: function(xhr, textStatus, errorThrown) {
                return errorThrown;
            }
    });

};
