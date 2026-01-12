<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch tasks grouped by status
$sql = "SELECT status, COUNT(*) AS total FROM tasks WHERE user_id=$user_id GROUP BY status";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Report</title>
</head>
<body>

<h2>Task Report</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Status</th>
        <th>Total Tasks</th>
    </tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo ucfirst($row['status']); ?></td>
        <td><?php echo $row['total']; ?></td>
    </tr>
<?php } ?>

</table>

<br>
<a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>



