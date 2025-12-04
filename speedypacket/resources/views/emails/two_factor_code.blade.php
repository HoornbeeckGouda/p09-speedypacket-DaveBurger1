<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Two-Factor Authentication Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #f8f8f8;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            color: #666666;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Two-Factor Authentication Code</h1>
        </div>
        <p>Hello,</p>
        <p>Your two-factor authentication code is:</p>
        <div class="code">{{ $code }}</div>
        <p>Please enter this code to complete your login. This code will expire in 10 minutes.</p>
        <p>If you did not request this code, please ignore this email.</p>
        <div class="footer">
            <p>SpeedyPacket - Secure Delivery Service</p>
        </div>
    </div>
</body>
</html>
