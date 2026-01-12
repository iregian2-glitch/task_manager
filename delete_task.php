<?php
session_start();
include "config.php";

if (!isset($_SESSION["user_id"]) || !isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit();
}

$task_id = $_GET["id"];
$user_id = $_SESSION["user_id"];

$sql = "DELETE FROM tasks WHERE id='$task_id' AND user_id='$user_id'";
mysqli_query($conn, $sql);

header("Location: dashboard.php");
exit();
?>


