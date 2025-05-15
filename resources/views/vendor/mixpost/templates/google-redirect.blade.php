<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to Google</title>
    <meta http-equiv="refresh" content="0; URL=https://www.google.com">
    <script type="text/javascript">
        window.location.href = "https://www.google.com";
    </script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            text-align: center;
            padding-top: 100px;
        }
        .redirect-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-weight: 500;
        }
        .spinner {
            margin: 20px auto;
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0,0,0,0.1);
            border-radius: 50%;
            border-top: 4px solid #3498db;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="redirect-container">
        <h1>Redirecting to Google</h1>
        <div class="spinner"></div>
        <p>You are being redirected to Google. If you are not redirected automatically, <a href="https://www.google.com">click here</a>.</p>
    </div>
</body>
</html>
