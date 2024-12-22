
<?php
// Define the blacklist of words (commands or forbidden inputs)
$blacklist = ['sleep', 'ping','|','||','&','&&','$()','``']; // Add more words as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and trim the user input
    $filename = trim($_POST['ip']); // Trim whitespace

    // Check if the input contains blacklisted words
    foreach ($blacklist as $blocked) {
        if (stripos($filename, $blocked) !== false) { // Case-insensitive check
            $result = "Input contains a blacklisted word.";
            echo $result;
            exit;
        }
    }

    // Define the command to ping the input
    $command = "ping -c 1 $filename";

    // Execute the command and capture the output
    $output = shell_exec($command);

    // Check if the command executed successfully and if TTL is found with some number
    if ($output !== NULL && preg_match('/ttl=\d+/i', $output)) {
        $result = "Ping successful.";
    } else {
        $result = "Ping failed.";
    }
} else {
    $result = "Invalid request method.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ping IP Address</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        #result {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ping IP Address</h1>
        <form method="post" action="">
            <input type="text" name="ip" placeholder="Enter IP Address" required>
            <button type="submit">Ping</button>
        </form>
        <div id="result">
            <?php
            if (isset($result)) {
                echo $result;
            }
            ?>
        </div>
 </div>
</body>
</html>
