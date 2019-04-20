<?php
include_once('includes/config.php');
include_once('includes/header.php');
if(isset($_POST['submit'])) {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    $sql ="INSERT INTO users(name,email, pass) VALUES(:name, :email, :password)";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':name', $name);
    $query-> bindParam(':email', $email);
    $query-> bindParam(':password', $password);
    $query->execute();

    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId) {
        echo "<script type='text/javascript'>alert('Registration Sucessfull!');</script>";
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    } else  {
        $error="Something went wrong. Please try again";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tachyons/4.11.1/tachyons.css">
</head>
<body>
    <form method="post" action="register.php" class="ba br3 w-30 center pb5 pl5 pr5 mt6">
        <div class="ma3 flex">
            <div class="w-40">Username:</div>
            <input class="w-60" type="text" name="name" required>
        </div>

        <div class="ma3 flex">
            <div class="w-40">Email:</div>
            <input class="w-60" type="text" name="email" required>
        </div>

        <div class="ma3 flex">
            <div class="w-40">Password:</div>
            <input class="w-60" type="password" name="password" id="password" required >
        </div>

        <br>
        <input class="center w-100 br3 bg-light-blue" name="submit" type="submit" value="Register">
        <br><br><p>Already have an account? <a href="index.php" >Click here</a></p>
    </form>
</body>
</html>