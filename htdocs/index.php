<?php
session_start();
include_once('includes/config.php');
include_once('includes/header.php');
if(isset($_POST['login'])) {
    $username=$_POST['username'];
    $password=md5($_POST['password']);

    $sql ="SELECT name,pass FROM users WHERE name=:username and pass=:password ";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() > 0) {
        $_SESSION['alogin']=$_POST['username'];
        echo $_SESSION['alogin'];
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details Or Account Not Confirmed');</script>";
    }
}
?>
<html>
<body>
<form method="post" action="index.php" class="ba br3 w-30 center pb5 pl5 pr5 mt6">
    <div class="ma3 flex">
        <div class="w-40">Username:</div>
        <input class="w-60" type="text" name="username" required>
    </div>

    <div class="ma3 flex">
        <div class="w-40">Password:</div>
        <input class="w-60" type="password" name="password" id="password" required >
    </div>

    <br>
    <input class="center w-100 br3 bg-light-blue" name="login" type="submit" value="Login">
    <br><br><p>Don't have an account? <a href="register.php" >Click here</a></p>
</form>
</body>
</html>