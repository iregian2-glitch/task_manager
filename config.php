<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "task_manager_db";

$conn= new mysqli($host, $user, $password,$database);

if($conn->connect_error){
    die("Failed to connect to MySQL:".$conn->connect_error);
}

