<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO tasks (user_id, title) VALUES ('$user_id', '$title')";
    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
</head>
<body>

<h2>Add New Task</h2>

<form method="POST">
    <input type="text" name="title" placeholder="Task Title" required><br><br>
    <button type="submit">Add Task</button>
</form>

<br>
<a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>


