<?php
$servername = "localhost";
$username = "aff1998";
$password = "aff";
$dbname = "userdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $email = $_POST['email'];
   $password=$_POST['password'];

   $error2 = $error3 =  "";

  

    if (empty($email)) {
        $error2 = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error2 = "Invalid email format";
    }

    if (empty($password)) {
        $error3 = "Password is required";
    } elseif (strlen($password) < 8) {
        $error3 = "Password must be at least 8 characters long";
    }

 

    if ( empty($error2) && empty($error3) ) {
 
        $email = $conn->real_escape_string($email);
       

        $sql = "SELECT email , password FROM reg where email = '$email' ";
$result=$conn->query($sql);
if($result->num_rows>0){
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];

       if(password_verify($password,$storedPassword)){
        echo "Login successful!";
       
    } else {
     
        echo "Invalid email or password.";
    }
} else {
 
     echo "<p style=color:red>No user found with this email.</p>";
}
       }
}


$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container my-5">
        <h2>Login Page </h2>
        <form action="" method="post">
           
            <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="email" value="">
                <?php  if(isset($error3)){echo  "<p style=color:red> $error2</p>" ;}; ?>
            </div>
            </div>
            <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="password" value="">
                <?php  if(isset($error3)){echo  "<p style=color:red> $error3</p>" ;}; ?>
            </div>
            </div>
           
            <div class="row mb-3">
            <div class="offset-sm-3 col-sm-3 d-grid">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-sm-3 d-grid">
                <a class="btn btn-outline-primary" href="" role="button">Cancel</a>
            </div>
            </div>
        </form>
    </div>
</body>
</html>