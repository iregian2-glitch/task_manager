<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit();
}

$task_id = $_GET["id"];
$user_id = $_SESSION["user_id"];

// Fetch task
$sql = "SELECT * FROM tasks WHERE id='$task_id' AND user_id='$user_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) != 1) {
    echo "Task not found!";
    exit();
}

$task = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $status = $_POST["status"];

    $update_sql = "UPDATE tasks SET title='$title', status='$status' WHERE id='$task_id' AND user_id='$user_id'";
    if (mysqli_query($conn, $update_sql)) {
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
    <title>Edit Task</title>
</head>
<body>

<h2>Edit Task</h2>

<form method="POST">
    <input type="text" name="title" value="<?php echo $task['title']; ?>" required><br><br>

    <select name="status">
        <option value="pending" <?php if($task['status']=='pending') echo 'selected'; ?>>Pending</option>
        <option value="completed" <?php if($task['status']=='completed') echo 'selected'; ?>>Completed</option>
    </select><br><br>

    <button type="submit">Update Task</button>
</form>

<br>
<a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>



