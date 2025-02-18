<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP Error Codes Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .error-card {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            justify-content: space-between;
            transition: all 0.3s ease;
        }
        .error-card:nth-child(odd) {
            flex-direction: row-reverse;
        }
        .error-card img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }
        .error-card:nth-child(odd) img {
            margin-right: 0;
            margin-left: 20px;
        }
        .error-card .content {
            flex: 1;
        }
        .error-card h3 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .error-card p {
            font-size: 16px;
            color: #666;
        }
        .error-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>HTTP Error Codes Documentation</h1>
    <p>Below is the documentation for common HTTP error codes, along with images for a better understanding.</p>

    <!-- Error 400 - Bad Request -->
    <div class="error-card">
        <img src="https://www.example.com/400.jpg" alt="400 Bad Request">
        <div class="content">
            <h3>400 - Bad Request</h3>
            <p>The request could not be understood by the server due to malformed syntax. The client should not repeat the request without modifications.</p>
        </div>
    </div>

    <!-- Error 401 - Unauthorized -->
    <div class="error-card">
        <img src="https://www.example.com/401.jpg" alt="401 Unauthorized">
        <div class="content">
            <h3>401 - Unauthorized</h3>
            <p>The request requires user authentication. The client must provide valid authentication credentials to access the resource.</p>
        </div>
    </div>

    <!-- Error 403 - Forbidden -->
    <div class="error-card">
        <img src="https://www.example.com/403.jpg" alt="403 Forbidden">
        <div class="content">
            <h3>403 - Forbidden</h3>
            <p>The server understood the request, but refuses to authorize it. This error may be due to lack of permission or invalid credentials.</p>
        </div>
    </div>

    <!-- Error 404 - Not Found -->
    <div class="error-card">
        <img src="https://www.example.com/404.jpg" alt="404 Not Found">
        <div class="content">
            <h3>404 - Not Found</h3>
            <p>The server could not find the requested resource. The client should verify the URL.</p>
        </div>
    </div>

    <!-- Error 500 - Internal Server Error -->
    <div class="error-card">
        <img src="https://www.example.com/500.jpg" alt="500 Internal Server Error">
        <div class="content">
            <h3>500 - Internal Server Error</h3>
            <p>The server encountered an unexpected condition that prevented it from fulfilling the request. This is usually a server-side issue.</p>
        </div>
    </div>

    <!-- Error 503 - Service Unavailable -->
    <div class="error-card">
        <img src="https://www.example.com/503.jpg" alt="503 Service Unavailable">
        <div class="content">
            <h3>503 - Service Unavailable</h3>
            <p>The server is temporarily unable to handle the request, often due to overload or maintenance. The client should try again later.</p>
        </div>
    </div>

</div>

</body>
</html>
