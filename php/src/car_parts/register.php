<?php
session_start();

require_once ('./php/connection.php');

$login = $password = $email = $full_name = $street_name = $city = $postcode = $country = "";
$telephone = $flat_nr = $street_nr = 0;
$error = false;
$error_msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $login = trim(mysqli_real_escape_string($link, $_POST['login']));
    $password = trim(mysqli_real_escape_string($link, $_POST['password']));
    $email = trim(mysqli_real_escape_string($link, $_POST['email']));
    $full_name = trim(mysqli_real_escape_string($link, $_POST['full_name']));
    $street_name = trim(mysqli_real_escape_string($link, $_POST['street_name']));
    $street_nr = intval(trim(mysqli_real_escape_string($link, $_POST['street_nr'])));
    $flat_nr = intval(trim(mysqli_real_escape_string($link, $_POST['flat_nr'])));
    $city = trim(mysqli_real_escape_string($link, $_POST['city']));
    $postcode = trim(mysqli_real_escape_string($link, $_POST['postcode']));
    $country = trim(mysqli_real_escape_string($link, $_POST['country']));
    $telephone = intval(trim(mysqli_real_escape_string($link, $_POST['telephone'])));

    if(empty($login)){
        $error_msg .= "Please enter a username.<br>";
        $error = true;
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', $login)){
        $error_msg .= "Username can only contain letters, numbers, and underscores.<br>";
        $error = true;
    } else{
        $sql = "SELECT id FROM customers WHERE username = ?";
        $stmt = mysqli_prepare($link, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $login);
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                if($result->num_rows > 0){
                    $error_msg .= "This username is already taken.<br>";
                    $error = true;
                }
            }
            mysqli_stmt_close($stmt);
        }
    }

    if(empty($password)){
        $error_msg .= "Please enter a password.<br>";
        $error = true;
    } elseif(strlen($password) < 6){
        $error_msg .= "Password must have atleast 6 characters.<br>";
        $error = true;
    }

    if(empty($email)){
        $error_msg .= "Please enter an email.<br>";
        $error = true;
    }
    if(empty($full_name)){
        $error_msg .= "Please enter a full name.<br>";
        $error = true;
    }
    if(empty($telephone)){
        $error_msg .= "Please enter a telephone.<br>";
        $error = true;
    }elseif($telephone < 100000000 || $telephone > 999999999){
        $error_msg .= "Please enter valid telephone number.<br>";
        $error = true;
    }
    if(empty($country)){
        $error_msg .= "Please enter a country.<br>";
        $error = true;
    }


    if(!$error){
        $sql = "INSERT INTO address VALUES (NULL, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_prepare($link, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "siisss", $street_name, $street_nr, $flat_nr, $city, $postcode, $country);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_get_result($stmt);
            } else{
                $error_msg .= "Error adding address to database.<br>";
                $error = true;
            }
            mysqli_stmt_close($stmt);
        }
    }

    $address_id = 0;
    if(!$error){
        $sql = "SELECT address_id FROM address WHERE street = ? AND street_nr = ? AND flat_nr = ? AND city = ? AND postcode = ? AND country = ?";
        $stmt = mysqli_prepare($link, $sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "siisss", $street_name, $street_nr, $flat_nr, $city, $postcode, $country);
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                $address = $result->fetch_assoc();
                $address_id = $address['address_id'];
            } else{
                $error_msg .= "Error adding address to database.<br>";
                $error = true;
            }
            mysqli_stmt_close($stmt);
        }
    }
    if(!$error){
        $sql = "INSERT INTO customers VALUES (NULL, ?, ?, ?, ?, ?, ?); ";
        $stmt = mysqli_prepare($link, $sql);
        if($stmt){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "sssiis", $login, $full_name, $email, $telephone, $address_id, $hash);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_get_result($stmt);
                header("location: index.php");
            } else{
                $error_msg .= "Error adding customer to database.<br>";
                $error = true;
            }
            mysqli_stmt_close($stmt);
        }
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
            <span class="far fa-user"></span> <input type="text" name="email" id="email" placeholder="Email">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="full_name" id="full_name" placeholder="Full name">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="telephone" id="telephone" placeholder="Telephone">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="street_name" id="street_name" placeholder="Street name (Optional)">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="street_nr" id="street_nr" placeholder="Street number (Optional)">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="flat_nr" id="flat_nr" placeholder="Flat number (Optional)">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="city" id="city" placeholder="City (Optional)">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="postcode" id="postcode" placeholder="Postcode (Optional)">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="country" id="country" placeholder="Country">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span> <input type="text" name="login" id="login" placeholder="Username">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span> <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <button class="btn mt-0" type="submit" value="Submit" name="register_button">Register</button>
        <div class="mx-auto mt-3">Registered? Click <a href="./login.php">here</a> to login into your account!</div>
    </form>
    <div class="back-to-shop"><a href="./index.php">&leftarrow;<span class="text-muted">Back to shop</span></a></div>
    <p class="text-danger"><?php if($error == true) echo $error_msg ;  ?></p>
</div>


</body>
</html>
