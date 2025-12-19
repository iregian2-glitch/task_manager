<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>

<body>

<?php
include "config.php";

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM tasks WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);


$status_filter = "";
if(isset($_GET['status_filter']) && $_GET['status_filter'] != "") {
    $status_filter = " AND status='" . $_GET['status_filter'] . "'";
}

$sql = "SELECT * FROM tasks WHERE user_id = $user_id $status_filter";
$result = mysqli_query($conn, $sql);
?>

<h2>Welcome, <?php echo $_SESSION["user_name"]; ?> 👋</h2>

<a href="add_task.php">➕ Add Task</a>
<br><br>

<form method="GET">
    <label>Filter by Status:</label>
    <select name="status_filter">
        <option value="">All</option>
        <option value="pending" <?php if(isset($_GET['status_filter']) && $_GET['status_filter']=='pending') echo 'selected'; ?>>Pending</option>
        <option value="completed" <?php if(isset($_GET['status_filter']) && $_GET['status_filter']=='completed') echo 'selected'; ?>>Completed</option>
    </select>
    <button type="submit">Filter</button>
</form>
<br>

<table border="1" cellpadding="10">
    <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Added On</th>
        <th>Actions</th>
    </tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row["title"]; ?></td>
        <td><?php echo $row["status"]; ?></td>
        <td><?php echo $row["created_at"]; ?></td>
        <td>
            <a href="edit_task.php?id=<?php echo $row["id"]; ?>">Edit</a> |
            <a href="delete_task.php?id=<?php echo $row["id"]; ?>">Delete</a>
        </td>
    </tr>
<?php } ?>

</table>

<br>
<a href="report.php">📊 View Report</a>
<br>

<br>
<a href="logout.php">Logout</a>

</body>
</html>


