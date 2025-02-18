<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1a1a1a;
            color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
            background-image: url('https://source.unsplash.com/1600x900/?abstract,technology');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            transition: all 0.3s ease-in-out;
        }

        h1 {
            font-size: 10rem;
            font-weight: bold;
            color: #ff6347;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);
            margin-bottom: 20px;
        }

        .emoji {
            font-size: 6rem;
            color: #ff6347;
            margin-bottom: 30px;
            animation: bounce 1s infinite alternate;
        }

        p {
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .action-btn {
            padding: 12px 30px;
            font-size: 1.1rem;
            background-color: #ff6347;
            color: white;
            border: 2px solid transparent;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #e94e3d;
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
        }

        footer {
            position: absolute;
            bottom: 20px;
            font-size: 1rem;
            color: rgba(255, 255, 255, 1); /* Increased opacity */
            text-align: center;
            width: 100%;
            padding: 10px 0;
        }

        footer a {
            color: #ff6347;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @keyframes bounce {
            0% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="emoji">🤯</div>
        <p>Oops! The page you're looking for can't be found.</p>
        <p>It seems like you've taken a wrong turn!</p>
        <a href="dashboard.php" class="action-btn">Go Back to Homepage</a>
    </div>

    <footer>
        <p>© <?php echo date('Y'); ?> All Rights Reserved by <a href="https://t.me/CallMeIronMan" target="_blank">TechFusion</a></p>
    </footer>
</body>
</html>
