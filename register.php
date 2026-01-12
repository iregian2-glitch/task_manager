<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <Style>
      .body{
        background-color: #eaf2f8;
        font-family: Arial, Helvetica, sans-serif;
      }
      .container{
        width: 350px;
    margin: 100px auto;
    padding: 25px;
    background-color: #ffffff;
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
    background-color: #3498db;  
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 15px;
    }
  </style>
</head>
<body>


<div class="container" border="10" align ="center" style="margin-top:100px;" background-color:lightblue;>
    
<h2><i>Register here</i></h2>

<form action="register.php" method="POST">
     <label>Username</label>
       <input type="text" name="username">  <br><br>
     <label>Email</label>
       <input type="text" name="email">     <br><br>
    <label>Password</label>
        <input type="password" name="password">  <br><br>
    
    <button type="submit" name="register">Register</button>

</div>
</form>


</body>
</html>

<?php
  include("config.php");  //database connect


  if(isset($_POST['register'])){        //get information from the register html form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
 
 //make sure all fields are filled
    if(empty($username)){
    echo "You have to enter your username";
 }
 if(empty($email)){
    echo "You have to enter your email";
 }
 if(empty($password)){
    echo "You have to enter your password";
 }

 
//has the password (should be before saving to the database)
$hashedPassword=password_hash($password, PASSWORD_DEFAULT);
   
}

  //save the data from the register page into the database.
  $conn="INSERT INTO users (name, email, password) VALUES ('$username', '$email', '$hashedPassword')";
   
  if(mysqli_query($mysql, $mysqli)){   //helps confirm if the record has been added
    echo "New record created successfully";
} else {
    echo "Error: " . $mysql . "<br>" . mysqli_error($mysql);
}
mysqli_close($mysql);

header("Location: index.php");
exit();
?>
