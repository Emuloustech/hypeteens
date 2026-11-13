
<?php
require_once __DIR__ . "/config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (
        $full_name === "" ||
        $username === "" ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($password) < 12
    ) {
        $message = "Please enter valid details. Password must contain at least 12 characters.";

    } else {

        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO admins (full_name, username, email, password_hash)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssss",
                $full_name,
                $username,
                $email,
                $password_hash
            );

            $stmt->execute();

            $message = "Administrator account created successfully!";

            $stmt->close();

        } catch (mysqli_sql_exception $e) {
            $message = "Account creation failed. Username or email may already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create HYPETEENS Admin</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .admin-box {
            background: white;
            width: 350px;
            max-width: 90%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        }

        h2 {
            color: #102A43;
            text-align: center;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #102A43;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="admin-box">

    <h2>Create Admin Account</h2>

    <?php if ($message !== ""): ?>
        <p class="message">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Full Name</label>
        <input type="text" name="full_name" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Password (minimum 12 characters)</label>
        <input type="password" name="password" minlength="12" required>

        <button type="submit">Create Admin Account</button>

    </form>

</div>

</body>
</html>
