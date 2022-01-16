<?php
session_start();
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
                <li class="nav-item"><a class="nav-link active" href="./about.php">About</a></li>
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
        <p>We offer highest and best variety of auto parts and accessories that perfectly suits your vehicle. We offer
            both OEM and aftermarket parts. If you want to save your money by purchasing aftermarket parts or original
            parts then you will be able to find the parts and accessories you need at TAPS. Whatever you’re
            automotive-related needs, you can easily fulfil it with us just a few click of online order on our portal.
            TAPS has a large product selection and supply of auto parts as well the car accessories range of various
            cars. These are about a million automotive parts and the auto accessories in order to satisfy every car
            owner’s demand as well.</p>
        <p>
            We offer hassle free shipping of your ordered parts at your door step or business within one business day
            with the best offer. You can search on our website for auto parts of your cars and accessories as per to
            their name, brands, make, model, year and part respectively. If you’re looking for any specific auto part
            component that matches the need of your vehicle, then you have just to type the respective part name on
            our auto parts gallery search bar, and then simply choose your car parts that matches the model of
            your car.
        </p>
        <p>
            In case you purchase a wrong auto part or you are not satisfied by the product then you can easily return
            that spare part without any problem. You just simply submit your return request within 30 days of your
            purchase; you will receive a mail in which you will get all details of product returning.
        </p>
        <p>
            If you drive vintage cars or a new model vehicle, then it is very difficult to get the original spare part
            of that particular vehicle, but we also provide these procure model spare parts. Whatever you’re
            automotive-related needs, you can easily fulfil it with us just a few click of online order on our portal.
            We make buying vehicle parts online simpler by giving exact and detailed fitment data, which makes for a
            clear and bother free shopping experience. Our built-in vehicle selector additionally permits you to look
            from our list of aftermarket parts and adornments by year, make, and model, so you're constantly ensured
            an ideal fit for your vehicle.
        </p>
    </div>
</section>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Car parts 2021</p></div>
</footer>
</body>
</html>