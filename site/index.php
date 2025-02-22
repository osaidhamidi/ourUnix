
<?php

$servername = "db"; 
$username = "root";
$password = "123"; 
$dbname = "dict"; 

$conn = new mysqli($servername, $username, $password, $dbname);

$word = "";
$definition = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $word = $_POST["word"];

    $stmt = $conn->prepare("SELECT def FROM mywords WHERE word = ?");
    $stmt->bind_param("s", $word);  
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $definition = $row["def"];
    } else {
        $definition = "Word not found in the dictionary.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Dictionary Application</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 28px;
            margin: 20px 0;
        }
        form {
            width: 400px;
            margin: 0 auto 20px;
            padding: 20px;
            background: #f0f0f0;
            border: 1px solid #000;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
        }

        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #000;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            background: #ddd;
            border: 1px solid #000;
            font-size: 16px;
            cursor: pointer;
        }

        h2 {
            font-size: 24px;
            margin: 20px 0 10px;
        }

        p {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            background: #f0f0f0;
            border: 1px solid #000;
            font-size: 16px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <h1>My Dictionary</h1>
    <form method="POST" action="">
        <label for="word">Enter a word:</label>
        <input type="text" id="word" name="word" required>
        <button type="submit">Go</button>
    </form>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <h2>Data:</h2>
        <p><?php echo htmlspecialchars($definition); ?></p>
    <?php endif; ?>
</body>
</html>