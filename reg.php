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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $coPassword = $_POST['coPassword'];

    $error1 = $error2 = $error3 = $error4 = $errorEmail= "";

    if (empty($name)) {
        $error1 = "Name is required";
    }

    if (empty($email)) {
        $error2 = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error2 = "Invalid email format";
    }else {
        // Check if email already exists
        $email = $conn->real_escape_string($email);
        $sql = "SELECT * FROM reg WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $errorEmail = "Email already exists";
            
        }}

    if (empty($password)) {
        $error3 = "Password is required";
    } elseif (strlen($password) < 8) {
        $error3 = "Password must be at least 8 characters long";
    }

    if ($password !== $coPassword) {
        $error4 = "Passwords do not match";
    }

    if (empty($error1) && empty($error2) && empty($error3) && empty($error4)&& empty($errorEmail)) {
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $password = password_hash($conn->real_escape_string($password), PASSWORD_DEFAULT);

        $sql = "INSERT INTO reg (name, email, password) VALUES ('$name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: reg.php");
            exit();
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
        <h2>Registration Page </h2>
        <form action="" method="post">
            <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="name" value="">
                <?php  if(isset($error3)){echo  "<p style=color:red> $error1</p>" ;}; ?>
            </div>
            </div>
            <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="email" value="">
                <?php  if(isset($error3)){echo  "<p style=color:red> $error2</p>" ;}; ?>
               <?php  if(isset($errorEmail)){echo  "<p style=color:red> $errorEmail</p>" ;}; ?>
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
            <label class="col-sm-3 col-form-label">Confirm Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="coPassword" value="">
                <?php  if(isset($error3)){echo  "<p style=color:red> $error4</p>" ;}; ?>
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