<?php require_once "config.php";?>
<?php
session_start();


$owner_id = $_SESSION['user_id'] ?? null;
if (!$owner_id) {
    die("You must be logged in");
}

// Get all projects for this user
$projects = $conn->query("SELECT * FROM projects WHERE owner_id = $owner_id ORDER BY id DESC");
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
      
table { 
    border-collapse: collapse; 
    width: 90%; 
    margin-bottom: 20px; 
}
th, td { border: 1px solid #ccc;
     padding: 8px; 
     text-align: left; }
th { background-color: #4b4f52ff; 
    color: white; 
}
tr:nth-child(even) { 
    background-color: #f2f2f2; 
    }
</style>

</style>
</head>
<body align="center">
<h1>Welcome to your Dashboard</h1>
<p>Would you like to add a task?</p>
<button><a href="add_task.php">Add Task</a></button>
<br><br>

<div class="container">
    <h2>Your projects and tasks are as follow</h2>
</div>

<h2>Your Projects</h2>

<?php if($projects->num_rows > 0): ?>
<table border="10" cellpadding="1" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Created At</th>
    </tr>

    <?php while($project = $projects->fetch_assoc()): ?>
<tr>
    td><?= $project['id'] ?></td>
    td><?= htmlspecialchars($project['name']) ?></td>
 <td><?= htmlspecialchars($project['description']) ?></td>
<td><?= $project['created_at'] ?? 'N/A' ?></td>
    </tr>

    <!-- Fetch and display tasks for this project -->
    <?php
        $project_id = $project['id'];
        $tasks = $conn->query("SELECT * FROM tasks WHERE project_id = $project_id");
    ?>
    <?php if($tasks->num_rows > 0): ?>
    <tr>
         <td colspan="4">
    <b>Tasks:</b>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
 <tr>
    <th>Title</th>
        <th>Description</th>
            <th>Due Date</th>
                <th>Status</th>
                </tr>
                <?php while($task = $tasks->fetch_assoc()): ?>
     <tr>
    <td><?= htmlspecialchars($task['title']) ?></td>
     <td><?= htmlspecialchars($task['description']) ?></td>
    <td><?= $task['due_date'] ?? 'N/A' ?></td>
         <td><?= $task['status'] ?></td>
                </tr>
            <?php endwhile; ?>
  </table>
    </td>
    </tr>
    <?php else: ?>
    <tr>
        <td colspan="4"><i>No tasks for this project yet.</i></td>
    </tr>
    <?php endif; ?>

    <?php endwhile; ?>
</table>

<?php else: ?>
<p>You have no projects yet.</p>
<?php endif; ?>






<button><a href="logout.php">Logout</a></button>
</body>
</html>