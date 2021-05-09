<?php
session_start();
require_once "connect.php";
$row = $result3 = $email = $comment = $successmessage = $message = '';
$email_error = $comment_error = '';


if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM BLOG WHERE ID=$id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $sql = "SELECT * FROM BLOG WHERE ID=$id";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    $sql4 = "SELECT * FROM COMMENT WHERE BLOGID=$id";
    $result3 = mysqli_query($link, $sql4);
}

if (isset($_POST["commentsubmit"])) {
    if (isset($_SESSION["username"])) {
        if (empty($_POST["email"])) {
            $email_error = "Email required";
        } else {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $email = $_POST["email"];
            } else {
                $email_error = "Invalid email";
            }
        }

        if (empty($_POST["comment"])) {
            $comment_error = "Comment is required";
        } else {
            $comment = trim($_POST["comment"]);
        }

        if (empty($email_error) && empty($comment_error)) {
            $blogid = $_POST["id"];
            $username = $_SESSION["username"];
            $id = $_SESSION["id"];
            $sql3 = "SELECT USERNAME,IMAGE FROM USER WHERE ID=$id";
            $result2 = mysqli_query($link, $sql3);
            $row3 = mysqli_fetch_assoc($result2);
            $date = date('y-m-d');
            $image = $row3["IMAGE"];
            if (empty($image)) {
                $message = "Please upload Image";
            } else {
                $sql = "INSERT INTO COMMENT VALUES(null,$blogid,'$username','$email','$comment','$date','$image')";
                if (mysqli_query($link, $sql)) {
                    $successmessage = "Thanks for comment";
                    $sql = "SELECT * FROM BLOG WHERE ID=$blogid";
                    $result = mysqli_query($link, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $sql4 = "SELECT * FROM COMMENT WHERE BLOGID=$blogid";
                    $result3 = mysqli_query($link, $sql4);
                } else {
                    $message = "Something is worng for comment";
                    $sql = "SELECT * FROM BLOG WHERE ID=$blogid";
                    $result = mysqli_query($link, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $sql4 = "SELECT * FROM COMMENT WHERE BLOGID=$blogid";
                    $result3 = mysqli_query($link, $sql4);
                }
            }
        }
        $blogid = $_POST["id"];
        $sql = "SELECT * FROM BLOG WHERE ID=$blogid";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        $sql4 = "SELECT * FROM COMMENT WHERE BLOGID=$blogid";
        $result3 = mysqli_query($link, $sql4);
    } else {
        $_SESSION["delete"] = "Please login for comment";
        header("Location:login.php");
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
    <div class="uk-child-width-1-1@m" uk-grid>
        <div>
            <div class="uk-card uk-card-default">
                <div class="uk-card-media-top uk-cover-container uk-height-large">
                    <img src="<?php echo ($row["Image"]); ?>" alt="">
                </div>
                <br>
                <div class="uk-container">
                    <article class="uk-article">

                        <h1 class="uk-article-title"><a class="uk-link-reset" href=""><?php echo ($row["Heading"]); ?></a></h1>

                        <p class="uk-article-meta">Written by <a href="#"><?php echo ($row["username"]); ?></a> on <?php echo ($row["Date"]); ?>. Posted in <a href="#">Blog</a></p>

                        <p class="uk-text-lead"><?php echo ($row["About"]); ?>.</p>

                        <p><?php echo (substr($row["Description"], 0, 50) . "......"); ?></p>

                        <div class="uk-grid-small uk-child-width-auto" uk-grid>
                            <div>
                                <a class="uk-button uk-button-text" href="#modal-container" uk-toggle>Read More</a>

                            </div>
                            <div>
                                <a class="uk-button uk-button-text" href="#comment">5 Comments</a>
                            </div>
                        </div>

                    </article>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-container" class="uk-modal-container" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h2 class="uk-modal-title">Headline</h2>
            <p><?php echo ($row["Description"]); ?></p>
        </div>
    </div>
    <br>
    <hr<<br>
        <div class="uk-container">
            <form action="<?php echo ($_SERVER["PHP_SELF"]) ?>" method="POST">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend">Comment</legend>
                    <input type="hidden" value="<?php echo ($row["id"]); ?>" name="id">
                    <div class="uk-margin">
                        <input class="uk-input" type="email" placeholder="Email" name="email">
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

                    <div class="uk-margin">
                        <textarea class="uk-textarea" rows="5" placeholder="Enter  something" name="comment"></textarea>
                        <?php
                        if ($comment_error) {
                        ?>
                            <div class="uk-alert-danger" uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <p><?php echo ($comment_error) ?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary" type="submit" name="commentsubmit">Submit</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="uk-container" id="comment" uk-overflow-auto>
            <?php
            while ($row2 = mysqli_fetch_assoc($result3)) {
            ?>
                <article class="uk-comment uk-comment-primary">
                    <header class="uk-comment-header">
                        <div class="uk-grid-medium uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <img class="uk-comment-avatar" src="<?php echo ($row2["Image"]); ?>" width="80" height="80" alt="">
                            </div>
                            <div class="uk-width-expand">
                                <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#"><?php echo ($row2["username"]); ?></a>
                                </h4>
                                <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                    <li><a href="#"><?php $d1 = date_create(date('y-m-d'));
                                                    $d2 = date_create($row2["Date"]);
                                                    echo (date_diff($d1, $d2)->format("%a")); ?> days ago</a></li>
                                    <li><a href="#">Reply</a></li>
                                </ul>
                            </div>
                        </div>
                    </header>
                    <div class="uk-comment-body">
                        <p><?php echo ($row2["comment"]); ?></p>
                    </div>
                </article>
            <?php } ?>

        </div>
        <div class="uk-text-center">
            <a href="" class="uk-icon-button uk-margin-small-right" uk-icon="twitter"></a>
            <a href="" class="uk-icon-button  uk-margin-small-right" uk-icon="facebook"></a>
            <a href="" class="uk-icon-button" uk-icon="youtube"></a>
        </div>
        <p class="uk-text-meta uk-text-center">Created by @Ashish Kumar 22022</p>
</body>

</html>