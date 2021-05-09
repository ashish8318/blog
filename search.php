<?php 
require_once "connect.php";
session_start();
$message='';
if(isset($_GET["data"]))
{
    $data=trim($_GET["data"]);
    $sql="SELECT HEADING,DATE,IMAGE,ABOUT,ID FROM BLOG WHERE HEADING LIKE '%$data%'";
    $result=mysqli_query($link,$sql);
    if(mysqli_num_rows($result)<1)
    {
        $message="Record is not found";
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
  <br><br>
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

    <div id="modal-full" class="uk-modal-full uk-modal" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full" type="button" uk-close></button>
            <form class="uk-search uk-search-large" action="search.php">
                <input class="uk-search-input uk-text-center" type="text" placeholder="Search" autofocus name="data">
            </form>
        </div>
    </div>


    <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>
        <?php 
        while($row=mysqli_fetch_assoc($result))
        {
        ?>
        <div class="uk-card uk-card-default">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        <img class="uk-border-circle" width="60" height="40"
                            src="<?php echo ($row["IMAGE"]) ?>">
                    </div>
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom"><?php echo ($row["HEADING"]) ?></h3>
                        <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00"><?php echo ($row["DATE"]) ?></time></p>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <div class="uk-card-badge uk-label"><?php $d1 = date_create(date('y-m-d'));
                                                                $d2 = date_create($row["DATE"]);
                                                                $i = (int)date_diff($d1, $d2)->format("%a");
                                                                if ($i < 50) {
                                                                    echo ("NEW");
                                                                } ?></div>
                <p><?php echo ($row["ABOUT"]) ?></p>
            </div>
            <div class="uk-card-footer">
                <a href="./about.php?id=<?php echo ($row["ID"]) ?>" class="uk-button uk-button-text">Read more</a>
            </div>
        </div>
        <?php }?>
    
    </div>
</body>

</html>