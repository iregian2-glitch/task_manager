<?php
require_once("config.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$owner_id = $_SESSION['user_id'];
$success = $error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_project_tasks'])) {

    //Insert Project
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (empty($name)) {
        $error = "Project name is required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO projects (name, description, owner_id) VALUES (?, ?, ?)");
        if (!$stmt) die("Prepare failed: ".$conn->error);

 $stmt->bind_param("ssi", $name, $description, $owner_id);
  if ($stmt->execute()) {
    $project_id = $stmt->insert_id; // ID of the new project
 $_SESSION['last_project_id'] = $project_id;
   $success = "Project created successfully!";

            $stmt->close();  //finish the projects part

// Insert Tasks to the databasese
if (!empty($_POST['tasks'])) {
 $task_stmt = $conn->prepare("INSERT INTO tasks (title, description, due_date, status, created_by, project_id) VALUES (?, ?, ?, 'pending', ?, ?)");
if (!$task_stmt) die("Prepare failed: ".$conn->error);

    foreach ($_POST['tasks'] as $task) {
        $title = trim($task['title']);
             $description_task = trim($task['description']);
                 $due_date = $task['due_date'] ?: NULL;

       if ($title !== "") {
      $task_stmt->bind_param("sssii", $title, $description_task, $due_date, $owner_id, $project_id);
  $task_stmt->execute();
                    }
                }
    $task_stmt->close();
    $success .= " Tasks added successfully!";
            }

        } else {
            $error = "project insert failed: ".$stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Project & Tasks</title>
<style>
body { font-family: Arial, sans-serif;
   background-color:
    #7e7e7eff;
   }

.container { width: 500px; margin: 50px auto; padding: 20px; background: #ccccccff; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
h2 { text-align: center; }
input, textarea { width: 100%; padding: 8px; margin-top: 4px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc; }
button { width: 100%; padding: 10px; background: #3498db; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
button:hover { background: #112736ff; }
.error { color: red; margin-bottom: 10px; }
.success { color: green; margin-bottom: 10px; }
.task { border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px; }
</style>
</head>
<body>
<div class="container">
    <h2>Add Project & Tasks</h2>

    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <?php if($success) echo "<p class='success'>$success</p>"; ?>

    <form method="POST">
      
        <label>Project Name</label>
 <input type="text" name="name" required>
    <label>Project Description</label>
 <textarea name="description"></textarea>

        <hr>

     
        <div class="task">
            <label>Task 1 Title</label>
    <input type="text" name="tasks[0][title]" required>
  <label>Description</label>
  <textarea name="tasks[0][description]"></textarea>
        <label>Due Date</label>
      <input type="date" name="tasks[0][due_date]">
        </div>

        <div class="task">
   <label>Task 2 Title</label>
    <input type="text" name="tasks[1][title]">
   <label>Description</label>
            <textarea name="tasks[1][description]"></textarea>
  <label>Due Date</label>
            <input type="date" name="tasks[1][due_date]">
        </div>

 <div class="task">
  <label>Task 3 Title</label>
    <input type="text" name="tasks[2][title]">
            <label>Description</label>
   <textarea name="tasks[2][description]"></textarea>
 <label>Due Date</label>
            <input type="date" name="tasks[2][due_date]">
        </div>

        <button type="submit" name="add_project_tasks">Add Project & Tasks</button>
    </form>
</div>
</body>
</html>


