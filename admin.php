<?php
session_start();
require_once "connect.php";
$message = $successmessage = '';
$uemail_error = '';
$uusername_error = '';
$uprofile_error = '';
$uprofilename = $uprofiletemp = '';
$uemail = $uusername = '';
$uprofilename = $uprofiletemp = $files = '';

$heading = $date = $category = $about = $description = $populer = $blogimagename = $blogimagetemp = '';

$heading_error = $date_error = $category_error = $about_error = $description_error = $blogimage_error = '';

if (isset($_SESSION["username"])) {
    if (isset($_POST["updateaccount"])) {

        if (empty($_POST["email"])) {
            $uemail_error = "Email required";
        } else {
            $uemail = $_POST["email"];
        }
        if (empty($_POST["username"])) {
            $uusername_error = "Username required";
            $message = "Username required";
        } else {
            $uusername = trim($_POST["username"]);
        }

        if (empty($_FILES["uprofile"])) {
            $uprofile_error = "Image required";
            $message = "Image required";
        } else {
            $files = $_FILES["uprofile"];
            $uprofilename = $files["name"];
            $uprofiletemp = $files["tmp_name"];
            $filetext = explode('.', $uprofilename);
            $filecheck = strtolower(end($filetext));
            $filetextstore = array('png', 'jpg', 'jpeg');
            if (!(in_array($filecheck, $filetextstore))) {
                $uprofile_error = "Please upload png jpg jpeg file";
                $message = "Please upload png jpg jpeg file";
            }
        }

        if ((empty($uemail_error) && empty($uusername_error) && empty($uprofile_error))) {
            $id = $_SESSION["id"];
            $destination = 'uploadimage/' . $uprofilename;
            move_uploaded_file($uprofiletemp, $destination);
            $sql = "UPDATE USER SET USERNAME='$uusername', EMAIL='$uemail',IMAGE='$destination' WHERE ID=$id";
            if (mysqli_query($link, $sql)) {
                $successmessage = "Account Updated";
            } else {
                $message = "Somethong is worng";
                echo ($uprofilename);
            }
        }
    }
        if (isset($_POST["addblog"])) {
            if (empty($_POST["heading"])) {
                $heading_error = "Heading is required";
                $message = "Data required";
            } else {
                $heading = trim($_POST["heading"]);
            }

            if (empty($_POST["date"])) {
                $date_error = "Date required";
                $message = "Data required";
            } else {
                $date = $_POST["date"];
            }

            if (empty($_POST["category"])) {
                $category_error = "Category required";
                $message = "Data required";
            } else {
                $category = trim($_POST["category"]);
            }

            if (empty($_POST["about"])) {
                $about_error = "About required";
                $message = "Data required";
            } else {
                $about = trim($_POST["about"]);
            }

            if (empty($_POST["description"])) {
                $description_error = "description required";
                $message = "Data required";
            } else {
                $description = trim($_POST["description"]);
            }

            if (empty($_FILES["blogimage"])) {
                $blogimage_error = "Image required";
                $message = "Image required";
            } else {
                $files = $_FILES["blogimage"];
                $blogimagename = $files["name"];
                $blogimagetemp = $files["tmp_name"];
                $filetext = explode('.', $blogimagename);
                $filecheck = strtolower(end($filetext));
                $filetextstore = array('png', 'jpg', 'jpeg');
                if (!(in_array($filecheck, $filetextstore))) {
                    $blogimage_error = "Please upload png jpg jpeg file";
                    $message = "Please upload png jpg jpeg file";
                }


                if (isset($_POST["populer"]))
                {
                    $populer=1;
                }
                else
                {
                    $populer=0;
                }
            }
            if ((empty($heading_error) && empty($date_error) && empty($category_error) && empty($about_error) && empty($description_error) && empty($blogimage_error))) {
                $id = $_SESSION["id"];
                $destination = 'uploadimage/' .$blogimagename;
                move_uploaded_file($blogimagetemp, $destination);
                $username=$_SESSION["username"];
                $id = $_SESSION["id"];
                $sql = "INSERT INTO BLOG VALUES('$heading','$date','$category','$about','$description',$populer,'$destination',null,$id,'$username')";
                if (mysqli_query($link, $sql)) {
                    $successmessage = "Blog Successfully ADD";
                } else {
                    echo(mysqli_error($link));
                    $message = "Somethong is worng";
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

                    
                    if (isset($_SESSION["username"])) {
                    ?>
                        <li><a href="#"><?php echo ($_SESSION["username"]) ?></a></li><?php } ?>
                    <li class="uk-active"><a href="index.php">Home</a></li>
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

    <div id="modal-full" class="uk-modal-full uk-modal" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full" type="button" uk-close></button>
            <form class="uk-search uk-search-large" action="search.php">
                <input class="uk-search-input uk-text-center" type="text" placeholder="Search" autofocus name="data">
            </form>
        </div>
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

        <hr>
        <br>
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

        <?php
        if (isset($_SESSION["delete"])) {
        ?>
            <div class="uk-alert-success uk-text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php echo ($_SESSION["delete"]);unset($_SESSION["delete"]) ?></p>
            </div>
        <?php
        }
        ?>

<?php
        if (isset($_SESSION["undelete"])) {
        ?>
            <div class="uk-alert-danger uk-text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php echo ($_SESSION["undelete"]); unset($_SESSION["undelete"])?></p>
            </div>
        <?php
        }
        ?>
        <br>
        <div>
            <div uk-grid>
                <div class="uk-width-auto@m">
                    <ul class="uk-tab-left" uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
                        <li><a href="#">All Blog</a></li>
                        <li><a href="#">User Details</a></li>
                        <li><a href="#">ADD Blog</a></li>
                        <li><a href="#">Update Account </a></li>
                    </ul>
                </div>
                <div class="uk-width-expand@m">
                    <ul id="component-tab-left" class="uk-switcher">
                        <li>
                            <div class="uk-overflow-auto">
                                <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
                                    <thead>
                                        <tr>
                                            <th class="uk-table-shrink">Image</th>
                                            <th class="uk-table-shrink">Heading</th>
                                            <th class="uk-table-expand">Written by</th>
                                            <th class="uk-width-small">Date</th>
                                            <th class="uk-width-small">Read More</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                       $userid=$_SESSION["id"];
                                       $sql2="SELECT * FROM BLOG WHERE USERID=$userid";
                                       $result=mysqli_query($link,$sql2);
                                       while($row=mysqli_fetch_assoc($result))
                                       {
                                    ?>
                                        <tr>
                                            <td><img class="uk-preserve-width" src="<?php echo($row["Image"])?>" width="80" alt=""></td>
                                            <td class="uk-text-nowrap"><?php echo($row["Heading"])?></td>
                                            <td class="uk-table-link">
                                                <a class="uk-link-reset" href=""><?php echo($row["username"])?></a>
                                            </td>
                                            <td class="uk-text-truncate"><?php echo($row["Date"])?></td>
                                            <td><a class="uk-button uk-button-default" type="button" href="./about.php?id=<?php echo($row["id"])?>">Read</a></td>
                                            <td><a class="uk-button uk-button-primary" type="button" href="./blogupdate.php?id=<?php echo($row["id"])?>">Update</a< /td>
                                            <td><a class="uk-button uk-button-danger" type="button" href="./deleteblog.php?id=<?php echo($row["id"])?>">Delete</a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        <li>
                            <div class="uk-overflow-auto">
                                <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
                                    <thead>
                                        <tr>
                                            <th class="uk-table-shrink">Image</th>
                                            <th class="uk-table-shrink">Name</th>
                                            <th class="uk-table-shrink">Email</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                    <?php 
                                      $sql1="SELECT * FROM USER WHERE ID=$userid";
                                      $result=mysqli_query($link,$sql1);
                                      while($row=mysqli_fetch_assoc($result))
                                      {
                                    ?>
                                        <tr>
                                            <td><img class="uk-preserve-width" src="<?php echo($row["Image"])?>" width="80" alt=""></td>
                                            <td class="uk-text-nowrap"><?php echo($row["username"])?></td>
                                            <td class="uk-table-link">
                                                <a class="uk-link-reset" href=""><?php echo($row["email"])?></a>
                                            </td>
                                            <td><a class="uk-button uk-button-danger" type="button" href="./deleteuser.php?id=<?php echo($row["id"]) ?>">Delete</a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </li>
                        <li>
                            <form class="uk-form-stacked uk-grid-small" uk-grid action="<?php echo ($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">

                                <div class="uk-margin uk-width-1-1">
                                    <label class="uk-form-label" for="form-stacked-text">Heading</label>
                                    <div class="uk-form-controls">
                                        <input class="uk-input" id="form-stacked-text" type="text" placeholder="Enter Heading" name="heading">
                                        <?php
                                        if ($heading_error) {
                                        ?>
                                            <div class="uk-alert-danger" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p><?php echo ($heading_error) ?></p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="uk-margin uk-width-1-2@s">
                                    <label class="uk-form-label" for="form-stacked-text">Date</label>
                                    <div class="uk-form-controls">
                                        <input class="uk-input" id="form-stacked-text" type="date" placeholder=" / / /" name="date">
                                        <?php
                                        if ($date_error) {
                                        ?>
                                            <div class="uk-alert-danger" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p><?php echo ($date_error) ?></p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="uk-margin uk-width-1-2@s">
                                    <label class="uk-form-label" for="form-stacked-select">Category</label>
                                    <div class="uk-form-controls">
                                        <select class="uk-select" id="form-stacked-select" name="category">
                                            <option>Option 01</option>
                                            <option>Option 02</option>
                                        </select>
                                    </div>
                                    <?php
                                    if ($category_error) {
                                    ?>
                                        <div class="uk-alert-danger" uk-alert>
                                            <a class="uk-alert-close" uk-close></a>
                                            <p><?php echo ($category_error) ?></p>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="uk-margin uk-width-1-1">
                                    <label class="uk-form-label" for="form-stacked-text">About</label>
                                    <div class="uk-form-controls">
                                        <textarea class="uk-textarea" rows="5" placeholder="Enter some Text About.." name="about"></textarea>
                                        <?php
                                        if ($about_error) {
                                        ?>
                                            <div class="uk-alert-danger" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p><?php echo ($about_error) ?></p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="uk-margin uk-width-1-1">
                                    <label class="uk-form-label" for="form-stacked-text">Description</label>
                                    <div class="uk-form-controls">
                                        <textarea class="uk-textarea" rows="5" placeholder="Enter Text Descriptions.." name="description"></textarea>
                                        <?php
                                        if ($description_error) {
                                        ?>
                                            <div class="uk-alert-danger" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p><?php echo ($description_error) ?></p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>


                                <div class="uk-margin uk-width-1-2@s">
                                    <div class="uk-form-label">Populer</div>
                                    <div class="uk-form-controls">
                                        <label><input class="uk-checkbox" type="checkbox" name="populer" value="Yes"> Yes</label>
                                    </div>

                                    <div class="uk-margin uk-width-1-2@s" uk-margin>
                                        <div uk-form-custom="target: true">
                                            <input type="file" name="blogimage">
                                            <input class="uk-input uk-form-width-medium" type="text" placeholder="Select Image" disabled >
                                        </div>
                                        <?php
                                        if ($blogimage_error) {
                                        ?>
                                            <div class="uk-alert-danger" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p><?php echo ($blogimage_error) ?></p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <button class="uk-button uk-button-primary" name="addblog" type="submit">ADD</button>
                            </form>
                        </li>

                        <li>
                            <form class="uk-form-stacked " action="<?php echo ($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">

                                <div class="uk-margin ">
                                    <label class="uk-form-label" for="form-stacked-text">Name</label>
                                    <div class="uk-form-controls">
                                        <input class="uk-input" id="form-stacked-text" type="text" placeholder="Enter Name" value="<?php echo ($_SESSION["username"]) ?>" name="username">
                                        <?php
                                        if ($uusername_error) {
                                        ?>
                                            <div class="uk-alert-danger" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p><?php echo ($uusername_error) ?></p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="uk-margin ">
                                    <label class="uk-form-label" for="form-stacked-text">Email</label>
                                    <div class="uk-form-controls">
                                        <input class="uk-input" id="form-stacked-text" type="email" placeholder="Enter Email" value="<?php echo ($_SESSION["email"]) ?>" name="email">
                                        <?php
                                        if ($uemail_error) {
                                        ?>
                                            <div class="uk-alert-danger" uk-alert>
                                                <a class="uk-alert-close" uk-close></a>
                                                <p><?php echo ($uemail_error) ?></p>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="uk-margin " uk-margin>
                                    <div uk-form-custom="target: true">
                                        <input type="file" name="uprofile">
                                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Select Image" disabled>
                                    </div>
                                    <?php
                                    if ($uprofile_error) {
                                    ?>
                                        <div class="uk-alert-danger" uk-alert>
                                            <a class="uk-alert-close" uk-close></a>
                                            <p><?php echo ($uprofile_error) ?></p>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <button class="uk-button uk-button-primary" name="updateaccount">Update</button>
                            </form>

                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <p class="uk-text-meta uk-text-center uk-position-bottom">Created by @Ashish Kumar 22022</p>
    </body>

    </html>
<?php
} else {
    header("Location:login.php");
}
?>