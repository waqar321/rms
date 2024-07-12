<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
        }
        .error-message {
            font-size: 24px;
            color: #e74c3c;
        }
        .back-link {
            color: #3498db;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="error-message">Page Not Found</h1>
    <p>The page you are looking for does not exist.</p>
    <p><a class="back-link" href="{{  url_secure('admin/dashboard') }}">Go back to Dashboard</a></p>
</div>
</body>
</html>
