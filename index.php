<?php
require_once "connect.php";
$results_per_page = 3;
$sql = "SELECT HEADING,DATE,IMAGE,ABOUT,ID FROM BLOG";
$r = mysqli_query($link, $sql);
$number_of_result = mysqli_num_rows($r);
$number_of_page = ceil($number_of_result / $results_per_page);
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
$page_first_result = ($page - 1) * $results_per_page;
$query = "SELECT HEADING,DATE,IMAGE,ABOUT,ID FROM BLOG LIMIT " . $page_first_result . ',' . $results_per_page;
$result = mysqli_query($link, $query);
$email = $feedbackmessage = $message = $successmessage = '';
$email_error = $feedbackmessage_error = '';
if (isset($_POST["feedback"])) {
    if (empty($_POST["email"])) {
        $email_error = "Email required";
        $message = "Email is required";
    } else {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["email"];
        } else {
            $email_error = "Invalid email";
            $message = "Invalid Email";
        }
    }
    if (empty($_POST["message"])) {
        $feedbackmessage_error = "Message is required";
        $message = "Message is required";
    } else {
        $feedbackmessage = trim($_POST["message"]);
    }

    if (empty($email_error) && empty($feedbackmessage_error)) {
        $sql = "INSERT INTO FEEDBACK  VALUES(null,'$email','$feedbackmessage')";
        if (mysqli_query($link, $sql)) {
            $successmessage = "Thanks for feedback";
        } else {
            $message = "Something  is Worng";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- UIkit CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.20/dist/css/uikit.min.css" /> -->

    <!-- UIkit JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.20/dist/js/uikit.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/uikit@3.6.20/dist/js/uikit-icons.min.js"></script> -->
    <!-- css -->
    <link rel="stylesheet" href="css/uikit.min.css" />
    <script src="js/uikit.min.js"></script>
    <script src="js/uikit-icons.min.js"></script>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Orelega+One&display=swap" rel="stylesheet">
    <title>Blooger</title>
</head>

<body>
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; bottom: #transparent-sticky-navbar">
        <nav class="uk-navbar-container" uk-navbar style="position: relative; z-index: 980;">
            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li class="uk-hidden@s"><a class="uk-navbar-toggle" uk-toggle="target: #offcanvas-usage">
                            <span uk-navbar-toggle-icon></span></a></li>
                    <li class="uk-active"><a href="#" style="font-family: 'Orelega One', cursive; font: 1000px;">Blooger</a></li>
                    <li>
                </ul>

            </div>

            <div class="uk-navbar-center">

                <ul class="uk-navbar-nav uk-visible@s">
                    <?php

                    session_start();
                    if (isset($_SESSION["username"])) {
                    ?>
                        <li><a href="#"><?php echo ($_SESSION["username"]) ?></a></li><?php } ?>
                    <li class="uk-active"><a href="#">Home</a></li>
                    <?php
                    if (isset($_SESSION["username"])) {
                    ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php
                    } else {
                    ?><li><a href="login.php">login</a></li><?php } ?>
                    <li><a href="admin.php">Dashbord</a></li>
                    <li><a href="#filter">Filter</a></li>
                </ul>

            </div>

            <div class="uk-navbar-right">
                <a class="uk-navbar-toggle" href="#modal-full" uk-search-icon uk-toggle></a>
                <ul class="uk-navbar-nav uk-visible@s">
                    <li class="uk-active"><a href="#"><span class="uk-margin-small-right" uk-icon="twitter"></span></a>
                    </li>
                    <li class="uk-active"><a href="#"><span class="uk-margin-small-right" uk-icon="linkedin"></span></a>
                    </li>
                    <li class="uk-active"><a href="#"><span class="uk-margin-small-right" uk-icon="facebook"></span></a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>

    <div id="offcanvas-usage" uk-offcanvas>
        <div class="uk-offcanvas-bar">
            <h3>Blogger</h3>
            <ul class="uk-nav uk-nav-default">
                <?php


                if (isset($_SESSION["username"])) {
                ?>
                    <li><a href="#"><?php echo ($_SESSION["username"]) ?></a></li><?php } ?>
                <li class="uk-active"><a href="#">Home</a></li>
                <?php
                if (isset($_SESSION["username"])) {
                ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php
                } else {
                ?><li><a href="login.php">login</a></li><?php } ?>
                <li><a href="admin.php">Dashbord</a></li>
                <li><a href="#filter">Filter</a></li>
                </li>
                <li class="uk-nav-header">Follow</li>
                <li class="uk-active"><a href="#"><span class="uk-margin-small-right" uk-icon="twitter"></span></a>
                </li>
                <li class="uk-active"><a href="#"><span class="uk-margin-small-right" uk-icon="linkedin"></span></a>
                </li>
                <li class="uk-active"><a href="#"><span class="uk-margin-small-right" uk-icon="facebook"></span></a>
                </li>
            </ul>
        </div>
        </nav>
    </div>
    </div>

    <?php
    if ($message) {
    ?>
        <div class="uk-alert-danger uk-text-center" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><?php echo ($message) ?></p>
        </div>
    <?php
    }
    ?>
    <?php
    if ($successmessage) {
    ?>
        <div class="uk-alert-success uk-text-center" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><?php echo ($successmessage) ?></p>
        </div>
    <?php
    }
    ?>

    <div id="modal-full" class="uk-modal-full uk-modal" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full" type="button" uk-close></button>
            <form class="uk-search uk-search-large" action="search.php">
                <input class="uk-search-input uk-text-center" type="text" placeholder="Search" autofocus name="data">
            </form>
        </div>
    </div>

    <div class="uk-height-large uk-background-cover uk-overflow-hidden uk-light uk-flex uk-flex-top" style="background-image: url(image/pexels-kelly-lacy-2876511.jpg);">
        <div class="uk-width-1-2@m uk-text-center uk-margin-auto uk-margin-auto-vertical">
            <h1 uk-parallax="opacity: 0,1; y: -50,0; scale: 2,1; viewport: 0.3;">Welcome Blooger</h1>
            <p uk-parallax="opacity: 0,1; y: 50,0; scale: 0.5,1; viewport: 0.3;">Lorem ipsum dolor sit amet, consectetur
                adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#34495E" fill-opacity="1" d="M0,256L120,224C240,192,480,128,720,133.3C960,139,1200,213,1320,250.7L1440,288L1440,0L1320,0C1200,0,960,0,720,0C480,0,240,0,120,0L0,0Z">
        </path>
    </svg>
    </div>
    <div class="uk-container">
        <div class="uk-slider-container-offset" uk-slider>

            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

                <ul class="uk-slider-items uk-child-width-1-3@s uk-grid">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                        <li>
                            <div class="uk-card uk-card-default">
                                <div class="uk-inline-clip uk-transition-toggle uk-card-media-top uk-cover-container uk-height-max-small" tabindex="0">
                                    <img src="<?php echo ($row["IMAGE"]) ?>" alt="">
                                    <div class="uk-transition-slide-bottom uk-position-bottom uk-overlay uk-overlay-default uk-background-secondary">
                                        <p class="uk-h4 uk-margin-remove uk-text-center"><?php echo ($row["HEADING"]) ?></p>
                                    </div>
                                </div>

                                <div class="uk-card-body">
                                    <h3 class="uk-card-title"><?php echo ($row["HEADING"]) ?></h3>
                                    <p>L<?php echo ($row["ABOUT"]) ?></p>
                                    <a class="uk-button uk-button-primary" href="./about.php?id=<?php echo ($row["ID"]) ?>">Read More</a>
                                </div>
                            </div>
                        </li>
                    <?php } ?>

                </ul>

                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

            </div>

            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
        </div>
        <br>
        <ul class="uk-pagination uk-pagination uk-flex-center">
            <li <?php if ($page - 1 <= 0) {
                    echo ('class="uk-disabled"');
                } ?>><a href="index.php?page=<?php if ($page - 1 >= 1) {
                                                    echo ($page - 1);
                                                } ?>"><span class="uk-margin-small-right" uk-pagination-previous></span> Previous</a></li>
            <li class="uk-margin-auto-left"><a href="index.php?page=<?php echo ($page + 1); ?>">Next <span class="uk-margin-small-left" uk-pagination-next></span></a></li>
        </ul>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#34495E" fill-opacity="1" d="M0,96L80,106.7C160,117,320,139,480,154.7C640,171,800,181,960,176C1120,171,1280,149,1360,138.7L1440,128L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z">
        </path>
    </svg>
    <hr>
    <h1 class="uk-heading-bullet uk-text-center">Filter Now</h1>

    <div class="uk-container" id="filter">
        <div uk-filter="target: .js-filter">

            <ul class="uk-subnav uk-subnav-pill">
                <li uk-filter-control=".tag-white"><a href="#">White</a></li>
                <li uk-filter-control=".tag-blue"><a href="#">Blue</a></li>
                <li uk-filter-control=".tag-black"><a href="#">Black</a></li>
            </ul>
            <hr>
            <ul class="js-filter uk-child-width-1-1@s  uk-child-width-1-3@m uk-text-center" uk-grid uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 500; repeat: true">
                <?php
                $sql = "SELECT HEADING,DATE,IMAGE,ABOUT,ID FROM BLOG";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <li class="tag-white">
                        <div class="uk-card uk-card-default uk-width-1-1@m">
                            <div class="uk-card-badge uk-label"><?php $d1 = date_create(date('y-m-d'));
                                                                $d2 = date_create($row["DATE"]);
                                                                $i = (int)date_diff($d1, $d2)->format("%a");
                                                                if ($i < 50) {
                                                                    echo ("NEW");
                                                                } ?></div>
                            <div class="uk-card-header">
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-auto">
                                        <img class="uk-border-circle" width="60" height="40" src="<?php echo ($row["IMAGE"]) ?>">
                                    </div>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom"><?php echo ($row["HEADING"]) ?></h3>
                                        <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00">
                                                <?php echo ($row["DATE"]) ?></time></p>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-body">
                                <p><?php echo ($row["ABOUT"]) ?></p>
                            </div>
                            <div class="uk-card-footer">
                                <a href="./about.php?id=<?php echo ($row["ID"]) ?>" class="uk-button uk-button-text">Read more</a>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center uk-margin-large-top" uk-grid>

        <div class="uk-animation-toggle">
            <div class="uk-background-secondary uk-padding uk-light uk-animation-slide-left">
                <h1 class="uk-heading-medium">About</h1>
                <hr class="uk-divider-icon">
                <p class="uk-text-capitalize uk-text-muted">Lorem Ipsum is simply dummy text of the printing and
                    typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has
                    survived not only five centuries, but also the leap into electronic typesetting, remaining
                    essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets
                    containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                    PageMaker including versions of Lorem Ipsum</p>
                <div class="uk-center">
                    <a href="" class="uk-icon-button uk-margin-small-right" uk-icon="twitter"></a>
                    <a href="" class="uk-icon-button  uk-margin-small-right" uk-icon="facebook"></a>
                    <a href="" class="uk-icon-button" uk-icon="youtube"></a>
                </div>
            </div>
        </div>
        <div class="uk-animation-toggle" tabindex="0" id="contect">
            <div class="uk-background-secondary uk-padding uk-light uk-height-1-1 uk-animation-slide-right">
                <h1 class="uk-heading-medium">Feedback</h1>
                <form class="uk-form-stacked" action="<?php echo ($_SERVER["PHP_SELF"]) ?>" method="POST">

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Email</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-stacked-text" type="email" placeholder="Enter your email..." name="email">
                            <?php
                            if ($email_error) {
                            ?>
                                <div class="uk-alert-danger" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <p><?php echo ($email_error) ?></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <textarea class="uk-textarea" rows="3" placeholder="Enter something..." name="message"></textarea>
                            <?php
                            if ($feedbackmessage_error) {
                            ?>
                                <div class="uk-alert-danger" uk-alert>
                                    <a class="uk-alert-close" uk-close></a>
                                    <p><?php echo ($feedbackmessage_error) ?></p>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <button class="uk-button uk-button-default" type="submit" name="feedback">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <p class="uk-text-meta uk-text-center">Created by @Ashish Kumar 22022</p>
</body>

</html>