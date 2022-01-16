<?php
session_start();

require_once ('./php/connection.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim(mysqli_real_escape_string($link, $_POST['login']));
    $password = trim(mysqli_real_escape_string($link, $_POST['password']));
    $login_error = $password_error =  "";
    $error = false;

    if(empty($login)){
        $login_error = "Please enter a username.";
        $error = true;
    }elseif(!preg_match('/^[a-zA-Z0-9_]+$/', $login)){
        $login_error = "Username can only contain letters, numbers, and underscores.";
        $error = true;
    }if(empty($password)){
        $password_error = "Please enter a password.";
        $error = true;
    }

    $sql = "SELECT password FROM customers WHERE username = ?";
    $stmt = mysqli_prepare($link, $sql);
    if($stmt && !$error){
        mysqli_stmt_bind_param($stmt, "s", $login);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if($result->num_rows == 1){
                $hash = $result->fetch_assoc();
                if(password_verify($password, $hash['password'])){
                    $_SESSION['login_user'] = $login;
                    $_SESSION['logged_in'] = true;
                    $_SESSION['products'] = 0;
                    header("location: index.php");
                }
                else{
                    $password_error = "Your password is invalid!";
                }
            } else{
                $login_error = "Your Login Name is invalid!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car parts shop</title>
    <meta name="description" content="Car parts shop">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>

<div class="wrapper" >
    <div class="logo"> <img src="./images/car_parts_logo.png" alt="car_parts_logo"> </div>
    <div class="text-center mt-4 name"> Car parts </div>
    <form class="p-3 mt-3" action="" method="post">
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="login" id="login" placeholder="Username">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span> <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <button class="btn mt-0" type="submit" value="Submit" name="login_button">Login</button>
        <div class="mx-auto mt-3">Not registered? Click <a href="./register.php">here</a> to create your account!</div>
    </form>
    <div class="back-to-shop"><a href="./index.php">&leftarrow;<span class="text-muted">Back to shop</span></a></div>
    <p class="text-danger">
        <?php
            if(isset($login_error) && $login_error != "") echo $login_error . '<br>';
            if(isset($password_error) && $password_error != "") echo $password_error . '<br>';
        ?>
    </p>
</div>


</body>
</html>
