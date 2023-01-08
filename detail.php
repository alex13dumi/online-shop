<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<!-- Topbar Start -->
<div class="container-fluid">
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Multi</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products">
                    <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0">Customer Service</p>
            <h5 class="m-0">+012 345 6789</h5>
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar Start -->
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    <div class="nav-item dropdown dropright">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Dresses <i class="fa fa-angle-right float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div>
                    <a href="" class="nav-item nav-link">Shirts</a>
                    <a href="" class="nav-item nav-link">Jeans</a>
                    <a href="" class="nav-item nav-link">Swimwear</a>
                    <a href="" class="nav-item nav-link">Sleepwear</a>
                    <a href="" class="nav-item nav-link">Sportswear</a>
                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                    <a href="" class="nav-item nav-link">Blazers</a>
                    <a href="" class="nav-item nav-link">Jackets</a>
                    <a href="" class="nav-item nav-link">Shoes</a>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                    <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="shop.php" class="nav-item nav-link">Shop</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                            <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                <a href="cart.php" class="dropdown-item">Shopping Cart</a>
                                <a href="checkout.php" class="dropdown-item">Checkout</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="" class="btn px-0">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                        <a href="" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->


<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="#">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <?php
                        $images = array("img/product-1.jpg", "img/product-2.jpg", "img/product-3.jpg", "img/product-4.jpg", "img/product-5.jpg", "img/product-6.jpg", "img/product-7.jpg", "img/product-8.jpg", "img/product-9.jpg", "img/product-10.jpg");
                        echo '<img class="w-100 h-100" src=\'' . $images[$_GET['id']-1] . '\'" alt="Image">';
                        //`numeClient`=\''.$_POST['search_client'].'\'
                        ?>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <?php

                $mysqli = new mysqli('localhost', 'alex13dumi', 'steaua86.', 'magArtSportiveDB'); //OOP Style
                $sql = 'SELECT `numeArticol`, `tipArticol`, `pretCurentArticol`, `descriereArticol`, `numeProducator` FROM `tblArticole` 
                        LEFT JOIN `tblProducatori` ON `tblArticole`.`codProducator` = `tblProducatori`.`idProducator` WHERE `idArticol`='.$mysqli->real_escape_string($_GET['id']);

                if(is_null($_SESSION['cart_products']))
                    $_SESSION['cart_products'] = [];

                if(!is_null($_POST['addToCart']))
                {
                    if(!array_key_exists($_GET['id'], $_SESSION['cart_products']))
                        array_push($_SESSION['cart_products'], $_GET['id']);
                }

                $result = $mysqli->query($sql);
                if (!$result->num_rows)
                    echo 'Invalid product!';

                else
                {
                    $i = 0;
                    while ($obj = $result->fetch_object())
                    {
                        echo '
                                <h3>'.$obj->numeArticol.'</h3>
                                    <div class="d-flex mb-3">
                                        <div class="text-primary mr-2">
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star-half-alt"></small>
                                            <small class="far fa-star"></small>
                                        </div>
                                        <small class="pt-1">(99 Reviews)</small>
                                    </div>
                                    <h3 class="font-weight-semi-bold mb-4">'.$obj->pretCurentArticol.'</h3>
                                    <div class="d-flex mb-3">
                                        <strong class="text-dark mr-3">Sizes:</strong>
                                        <form>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="size-1" name="size">
                                                <label class="custom-control-label" for="size-1">XS</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="size-2" name="size">
                                                <label class="custom-control-label" for="size-2">S</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="size-3" name="size">
                                                <label class="custom-control-label" for="size-3">M</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="size-4" name="size">
                                                <label class="custom-control-label" for="size-4">L</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="size-5" name="size">
                                                <label class="custom-control-label" for="size-5">XL</label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="d-flex mb-4">
                                        <strong class="text-dark mr-3">Colors:</strong>
                                        <form>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="color-1" name="color">
                                                <label class="custom-control-label" for="color-1">Black</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="color-2" name="color">
                                                <label class="custom-control-label" for="color-2">White</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="color-3" name="color">
                                                <label class="custom-control-label" for="color-3">Red</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="color-4" name="color">
                                                <label class="custom-control-label" for="color-4">Blue</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input" id="color-5" name="color">
                                                <label class="custom-control-label" for="color-5">Green</label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="d-flex align-items-center mb-4 pt-2">
                                        <div class="input-group quantity mr-3" style="width: 130px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <form method="post">
                                            <button type="submit" class="btn btn-primary px-3" name="addToCart">  
                                                <i class="fa fa-shopping-cart mr-1"></i>Add To Cart 
                                            </button>                                       
                                        </form>
                                    </div>
                                    <div class="d-flex pt-2">
                                        <strong class="text-dark mr-2">Share on:</strong>
                                        <div class="d-inline-flex">
                                            <a class="text-dark px-2" href="www.facebook.com">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                            <a class="text-dark px-2" href="www.twitter.com">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            <a class="text-dark px-2" href="www.pinterest.com">
                                                <i class="fab fa-pinterest"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row px-xl-5">
                            <div class="col">
                                <div class="bg-light p-30">
                                    <div class="nav nav-tabs mb-4">
                                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="tab-pane-1">
                                            <h4 class="mb-3">Product Description</h4>
                                            <p>'.$obj->descriereArticol.'</p>      
                                            <p>Producator: ' .$obj->numeProducator. '</p>
                                            <p>Tip articol: ' .$obj->tipArticol. '</p>
                                        </div>
                                </div>
                            </div>
                        </div>';
                    }
                }
                ?>
                <!-- Shop Detail End -->


                <!-- Products Start -->
                <div class="container-fluid py-5">
                    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
                    <div class="row px-xl-5">
                        <div class="col">
                            <div class="owl-carousel related-carousel">

                                <?php
                                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //Predefined Constants MySQLi

                                $images = array("img/product-1.jpg", "img/product-2.jpg", "img/product-3.jpg", "img/product-4.jpg", "img/product-5.jpg", "img/product-6.jpg", "img/product-7.jpg", "img/product-8.jpg", "img/product-9.jpg", "img/product-10.jpg");

                                //`numeClient`=\''.$_POST['search_client'].'\'
                                $mysqli = new mysqli('localhost', 'alex13dumi', 'steaua86.', 'magArtSportiveDB'); //OOP Style
                                $sql = 'SELECT `idArticol`, `numeArticol`, `pretCurentArticol` FROM tblArticole';
                                if (!is_null($mysqli))
                                {
                                    /*echo 'Success.....' . $mysqli->host_info;
                                    echo '<br></br>';
                                    echo 'Connected !\nClient library version: ' . $mysqli->client_info;
                                    echo '<br ></br >';
                                    echo 'Server' . $mysqli->server_info;*/
                                }
                                else
                                {
                                    echo "\nCouldn\'t connect to $mysqli->host_info\n";
                                }

                                $result = $mysqli->query($sql);
                                if (!$result->num_rows)
                                    throw new Exception('Name or telephone doesn\'t exist');

                                else
                                {
                                    $i=0;
                                    while ($obj = $result->fetch_object()) {
                                        echo '<div class="product-item bg-light">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src=\'' .$images[$i]. '\'" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="detail.php?id='.$obj->idArticol.'">'.$obj->numeArticol.'</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>' .$obj->pretCurentArticol. '</h5><h6 class="text-muted ml-2"><del>'.'pret redus'.'</del></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small>(99)</small>
                                    </div>
                                </div>
                            </div>';
                                        $i++;
                                    }
                                }
                                $result->close();
                                $mysqli->close();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Products End -->


                <!-- Footer Start -->
                <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
                    <div class="row px-xl-5 pt-5">
                        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                            <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                            <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no</p>
                            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                        </div>
                        <div class="col-lg-8 col-md-12">
                            <div class="row">
                                <div class="col-md-4 mb-5">
                                    <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                                    <div class="d-flex flex-column justify-content-start">
                                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                                        <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-5">
                                    <h5 class="text-secondary text-uppercase mb-4">My Account</h5>
                                    <div class="d-flex flex-column justify-content-start">
                                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                                        <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                                        <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-5">
                                    <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                                    <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                                    <form action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Your Email Address">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary">Sign Up</button>
                                            </div>
                                        </div>
                                    </form>
                                    <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>
                                    <div class="d-flex">
                                        <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                                        <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                                        <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                                        <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
                        <div class="col-md-6 px-xl-0">
                            <p class="mb-md-0 text-center text-md-left text-secondary">
                                &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                                by
                                <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                            </p>
                        </div>
                        <div class="col-md-6 px-xl-0 text-center text-md-right">
                            <img class="img-fluid" src="img/payments.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- Footer End -->


                <!-- Back to Top -->
                <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


                <!-- JavaScript Libraries -->
                <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
                <script src="lib/easing/easing.min.js"></script>
                <script src="lib/owlcarousel/owl.carousel.min.js"></script>

                <!-- Contact Javascript File -->
                <script src="mail/jqBootstrapValidation.min.js"></script>
                <script src="mail/contact.js"></script>

                <!-- Template Javascript -->
                <script src="js/main.js"></script>
</body>

</html>