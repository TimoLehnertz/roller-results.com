<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roller timing</title>
    <!-- <script type="module" src="https://unpkg.com/esp-web-tools@9/dist/web/install-button.js?module"></script> -->
    <script type="module" src="js/install-button.js"></script>
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #E0E0E0;
        }

        header {
            background-color: #1E88E5;
            color: #FFFFFF;
            text-align: center;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 3rem;
            margin: 0;
        }

        p {
            font-size: 1.2rem;
            color: #B0B0B0;
        }

        ul {
            padding: 0;
            margin: 1rem 0;
            padding-left: 1rem;
        }

        li {
            margin-bottom: 1rem;
        }

        .container {
            padding: 2rem;
            max-width: 800px;
            margin: 0 auto;
            background-color: #1C1C1C;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .esp-button-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        esp-web-install-button:hover {
            background-color: #1565C0;
        }

        @media screen and (max-width: 600px) {
            header {
                padding: 0.5rem;
            }

            h1 {
                font-size: 2rem;
            }

            .container {
                padding: 1rem;
            }

            esp-web-install-button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Roller timing</h1>
    </header>
    <div class="container">
        <p>Update your roller timing device to the newest firmware</p>
        <ul>
            <li>Make sure to use <b>Chrome browser</b></li>
            <li>Connect your device via USB</li>
            <li>Install</li>
            <li>After succsessfull update wait until the display of your device lights up again</li>
        </ul>
        In case of failure check that the wire is correctly inserted and repeat the process
        <div class="esp-button-wrapper">
            <esp-web-install-button manifest="manifest.json"></esp-web-install-button>
        </div>
    </div>
</body>
</html>