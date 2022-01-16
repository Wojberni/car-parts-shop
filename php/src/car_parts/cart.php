<?php
session_start();

require_once ('./php/connection.php');

$cart = array();
$final_price = 0;

if(isset($_SESSION['logged_in'])){
    $sql = "SELECT * FROM cart";
    $cart_result = $link->query($sql);
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $sql_row = 'SELECT id, name, price FROM car_parts WHERE id = ' .$row['part_id']. ' ';
        $product_result = $link->query($sql_row);
        $product_row = mysqli_fetch_assoc($product_result);
        $cart['name'][] = $product_row['name'];
        $cart['price'][] = $product_row['price'];
        $cart['id'][] = $product_row['id'];
        $cart['quantity'][] = $row['quantity'];
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['logged_in']) && isset($_POST['checkout_button']) && !empty($_SESSION['products'])) {
    $sql = "SELECT id FROM customers WHERE username = '" .$_SESSION['login_user']. "' ";
    $user_result = $link->query($sql);
    $user = mysqli_fetch_assoc($user_result);
    $sql = "INSERT INTO orders VALUES (NULL, " .$user['id']. ", 'in_progress', NOW())";
    $order_result = $link->query($sql);
    $insert_id = $link->insert_id;
    for($i = 0; $i < count($cart['id']); $i++){
        $sql = 'INSERT INTO order_item VALUES ( ' .$insert_id. ', ' .$cart['id'][$i]. ', ' .$cart['quantity'][$i]. ')';
        $insert_result = $link->query($sql);
    }
    $_SESSION['products'] = 0;
    $cart = array();
    $final_price = 0;
    $sql = "TRUNCATE TABLE cart";
    $link->query($sql);
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
    <link rel="stylesheet" href="./css/cart.css">
</head>
<body>

<div class="card">
    <div class="row">
        <div class="col-md-8 cart">
            <div class="title">
                <div class="row">
                    <div class="col">
                        <h4><b>Shopping Cart</b></h4>
                    </div>
                </div>
            </div>
            <?php
            if(isset($_SESSION['logged_in'])){
                if(!empty($cart)){
                    for($i = 0; $i < count($cart['id']); $i++){
                        $final_price += $cart['quantity'][$i] * $cart['price'][$i];
                        if($i == count($cart['id']) - 1)
                            echo '<div class="row border-top border-bottom">';

                        else
                            echo '<div class="row border-top">';
                        echo '
                            <div class="row main align-items-center text-center">
                                <div class="col-2"><img class="img-fluid" src="./images/' .$cart['name'][$i]. '.jpg"></div>
                                <div class="col">
                                    <div class="row">' .$cart['name'][$i]. '</div>
                                </div>
                                <div class="col">' .$cart['quantity'][$i]. '</div>
                                <div class="col">' .$cart['price'][$i]. ' $</div>
                            </div>
                        </div>
                    ';
                    }
                }
                else{
                    echo "No products added to cart!";
                }

            }
            else
                echo "You must be logged in to see your cart!";
            ?>

            <div class="back-to-shop"><a href="./index.php">&leftarrow;<span class="text-muted">Back to shop</span></a></div>
        </div>
        <div class="col-md-4 summary">
            <div>
                <h5><b>Summary</b></h5>
            </div>
            <hr>
            <div class="row">
                <div class="col" style="padding-left:0;">
                    <?php
                    if(isset($_SESSION['logged_in']))
                        echo $_SESSION['products'] . " items";
                    else
                        echo "0 items";
                    ?>
                </div>
                <div class="col text-right">
                    <?php echo $final_price . " $"; ?>
                </div>
            </div>
            <form action="" method="post">
                <p>SHIPPING</p>
                <select>
                    <option class="text-muted">Standard-Delivery - 20.00 $</option>
                </select>
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL PRICE</div>
                    <div class="col text-right">
                        <?php echo $final_price + 20 . " $"; ?>
                    </div>
                </div>
                <button class="btn" type="submit" value="Submit" name="checkout_button">Checkout</button>
            </form>
        </div>
    </div>
</div>