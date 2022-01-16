<?php
session_start();

require_once ('./php/connection.php');

$filter = 0;
$id_array = array();
$cart_msg = "";

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['filter_button'])){
        $filter = $_GET['category'];
        if(!empty($filter)){
            $sql = "SELECT part_id FROM category_item WHERE category_id = " . $filter;
            $result_part_id = $link->query($sql);
            while ($row = mysqli_fetch_assoc($result_part_id)) {
                $id_array[] = $row['part_id'];
            }

        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_SESSION['logged_in'])){
        if(isset($_POST['cart_button'])){
            $product_id = $_POST['cart_button'];
            $quantity = trim(mysqli_real_escape_string($link, $_POST['quantity']));
            $sql = "SELECT part_id FROM cart WHERE part_id = " .$product_id. " ";
            $select_res = $link->query($sql);
            if(mysqli_num_rows($select_res) == 1){
                $sql = 'UPDATE cart SET quantity = quantity + ' .$quantity. ' WHERE part_id = ' .$product_id. ' ';
                $result = $link->query($sql);
                if(!empty($result)){
                    $cart_msg = "Added item to cart!";
                }
                else
                    $cart_msg = "Error adding item to cart!";
            }
            else{
                $sql = "INSERT INTO cart VALUES (" .$product_id. ", " .$quantity. ")";
                $result = $link->query($sql);
                if(!empty($result)){
                    $cart_msg = "Added item to cart!";
                    $_SESSION['products'] += 1;
                }
                else
                    $cart_msg = "Error adding item to cart!";
            }

        }
    }
    else
        $cart_msg = "Login to add to cart!";
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="./index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="./about.php">About</a></li>
                <?php
                if(isset($_SESSION['logged_in'])){
                    echo '<li class="nav-item"><a class="nav-link" href="./logout.php">Logout</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="./order.php">Orders</a></li>';
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
                <h3 class="w-100 text-center font-weight-bold">
                    <?php if(!empty($cart_msg)) echo $cart_msg; ?>
                </h3>
                <form action="" method="get" class="p-3 mt-3 text-center w-100" >
                    <select name="category" id="category" class="custom-select custom-select-sm">
                        <option value="0">-- All categories --</option>
                        <?php
                        $sql = "SELECT name, id FROM category";
                        $result = $link->query($sql)->fetch_all(MYSQLI_ASSOC);
                        foreach($result as $product){
                            echo '<option ';
                            if($filter == $product['id'])
                                echo 'selected';
                            echo ' value="' .$product['id']. '">' .$product['name']. '</option>';
                        }
                        ?>
                    </select>
                    <button class="mt-3 btn btn-outline-dark center-block" type="submit" value="Submit" name="filter_button">Filter</button>
                </form>


                <?php
                        if(!empty($filter)){
                            $sql = 'SELECT id, name, price FROM car_parts WHERE id IN (' . implode(',', array_map('intval', $id_array)) . ')';
                        }
                        else{
                            $sql = "SELECT id, name, price FROM car_parts";
                        }
                        $result = $link->query($sql)->fetch_all(MYSQLI_ASSOC);
                        foreach($result as $product){
                            echo
                            '<div class="col mb-5 col-md-4">
                                <div class="card h-100">
                                    <!-- Product image-->
                                    <img class="card-img-top" src="./images/' .$product['name']. '.jpg " alt="part" />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder mb-0">' .$product['name']. '</h5>
                                            <!-- Product price-->
                                            <span>' .$product['price']. ' $</span><br>                                       
                                            <form action="" method="post">
                                            <input type="number" name="quantity" id="product_quantity" min="1" max="100" style="width: 30%; text-align: center;" value="1">
                                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                                                    <button class="btn btn-outline-dark center-block" type="submit" value="' .$product['id']. '" name="cart_button">Add to cart</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                mysqli_close($link);
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