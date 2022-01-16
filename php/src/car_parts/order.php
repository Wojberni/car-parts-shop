<?php
session_start();

require_once ('./php/connection.php');

$order_list = array();

$sql = "SELECT id FROM customers WHERE username = '" .$_SESSION['login_user']. "' ";
$user_result = $link->query($sql);
$user = mysqli_fetch_assoc($user_result);
$sql = "SELECT id, status, created_at FROM orders WHERE customer_id = " .$user['id']. " ";
$orders = $link->query($sql);
while($row = mysqli_fetch_assoc($orders)){
    $products_list = array();
    $sql = "SELECT product_id, quantity FROM order_item WHERE order_id = " .$row['id']. " ";
    $products_result = $link->query($sql);
    while($product_row = mysqli_fetch_assoc($products_result)){
        $sql = "SELECT id, name, price FROM car_parts WHERE id = " .$product_row['product_id']. " ";
        $part_result = $link->query($sql);
        $part = mysqli_fetch_assoc($part_result);
        $products_list['product_id'][] = $part['id'];
        $products_list['name'][] = $part['name'];
        $products_list['price'][] = $part['price'];
        $products_list['quantity'][] = $product_row['quantity'];
    }
    $order_list['products'][] = $products_list;
    $order_list['order_id'][] = $row['id'];
    $order_list['status'][] = $row['status'];
    $order_list['created_at'][] = $row['created_at'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Car parts shop">
    <title>Car parts shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="./index.php">
            <img src="./images/car_parts_logo.png" alt="car_parts_logo" height="50"><span>Car parts</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="./index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="./about.php">About</a></li>
                <?php
                if(isset($_SESSION['logged_in'])){
                    echo '<li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>';
                    echo '<li class="nav-item"><a class="nav-link active" href="./order.php">Orders</a></li>';
                }else{
                    echo '<li class="nav-item"><a class="nav-link" href="./login.php">Login/Register</a></li>';
                }
                ?>
            </ul>
            <form class="d-flex">
                <button class="btn btn-outline-dark">
                    <a href="./cart.php" style="color:black; text-decoration: none;">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">
                                <?php
                                if(isset($_SESSION['logged_in']))
                                    echo $_SESSION['products'];
                                else
                                    echo 0;
                                ?>
                            </span>
                    </a>
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">
                <?php
                if(isset($_SESSION['logged_in'])){
                    echo "Hello User " . $_SESSION['login_user'] . "!" ;
                }else{
                    echo "Hello Guest User!";
                }
                ?>
            </h1>
            <p class="lead fw-normal text-white-50 mb-0">Satisfaction guaranteed or we refund your purchase</p>
        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row justify-content-center">
            <h2>List of orders made by customer</h2>
            <?php
            if(isset($_SESSION['logged_in'])){
                if(!empty($order_list)){
                    for($i = 0; $i < count($order_list['order_id']); $i++){
                        echo "<p class='w-100 font-weight-bold'>Order ID: " .$order_list['order_id'][$i]. "<br>Order status: " .$order_list['status'][$i].
                            "<br>Order created at: " .$order_list['created_at'][$i]. "</p>";
                        for($j = 0; $j < count($order_list['products'][$i]['product_id']); $j++){
                            echo "<p class='w-100 pl-5 font-weight-bold'>Part ID: " . $order_list['products'][$i]['product_id'][$j] .
                                "<br>Product name: " . $order_list['products'][$i]['name'][$j] . "<br>Product price: " . $order_list['products'][$i]['price'][$j] .
                                "<br>Product quantity: " . $order_list['products'][$i]['quantity'][$j] . "</p>";
                        }
                    }
                }
                else{
                    echo "<p class='w-100 font-weight-bold'>No orders were made! Click on cart and create one!</p>";
                }
            }else{
                echo "<p class='w-100 font-weight-bold'>Log in to see your orders!</p>";
            }
            ?>
        </div>
    </div>
</section>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Car parts 2021</p></div>
</footer>
</body>
</html>