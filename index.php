<?php
   include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
.body{
        background-color: #2e343aff;
        font-family: Arial, Helvetica, sans-serif;
      }
      .container{
        width: 350px;
    margin: 100px auto;
    padding: 25px;
    background-color: #cccacaff;
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    text-align: center
      }
    .conatiner h2{
      margin-bottom: 20px;
    color: #2c3e50
    }
    .container input{
      width: 90%;
    padding: 8px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    }
    .container button{
       width: 95%;
    padding: 10px;
    background-color: #3498db;  /* blue */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 15px;
    }
</style>
</head>
<body>

<div class="container" border="10" align="center" style="margin-top:100px;">

<h2>Please key in your credentials</h2>

    <form action="index.php" method="POST" align="center">
        <label>Username</label>
        <input type="text" name="username"> <br><br>
        <label>Password</label>
        <input type="password" name="password"> <br><br>
        <button type="submit" name="submit">Submit</button>
    </form>

<p>Not registered?</p><button><a href="register.php">Register here</a></button>

</div>
</body>
</html>



<?php
//collect the form data

   if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

     if(empty($username)){
        echo "You have to enter your username";
     }
     if(empty($password)){
        echo "You have to enter your password";
     }

     // database logic here
     $sql= "SELECT id, password FROM users WHERE name = ?";
       $stmt = $conn->prepare($sql); //creates an SQL template
        $stmt->bind_param("s", $username); //attaches user input to the template
        $stmt->execute(); //runs the query,

        $reult = $stmt->get_result(); //gets the actual result
        if($reult->num_rows === 0){
            echo "No user found";
            exit();
        }
    $user = $reult->fetch_assoc();
    $hashedPassword = $user['password'];
    if(!password_verify($password, $hashedPassword)){
        echo "Incorrect password";
        exit();
    }
     // redirect to dashboard upon successful login
     header("Location: dashboard.php");
   }


?>
