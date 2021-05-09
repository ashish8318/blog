<?php
require_once "connect.php";
session_start();
$id=$row=$message=$successmessage ='';
$uprofilename = $uprofiletemp = $files = '';
$heading = $date = $category = $about = $description = $populer = $blogimagename = $blogimagetemp = '';

$heading_error = $date_error = $category_error = $about_error = $description_error = $blogimage_error = '';
if(isset($_SESSION["username"]))
{
    if(isset($_GET["id"]))
    {
        $id=$_GET["id"];
        $sql="SELECT * FROM BLOG WHERE ID=$id";
        $result=mysqli_query($link,$sql);
        $row=mysqli_fetch_assoc($result);
    }
    
    if(isset($_POST["updateblog"]))
    {   
        $id=$_POST["id"]; 
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
            $destination = 'uploadimage/' .$blogimagename;
            move_uploaded_file($blogimagetemp, $destination);
            $sql = "UPDATE BLOG SET HEADING='$heading', DATE='$date', CATEGORY='$category',ABOUT='$about',DESCRIPTION='$description',IMAGE='$destination',POPULER='$populer' WHERE ID=$id";
            if (mysqli_query($link, $sql)) {
                $successmessage = "Blog Successfully Update";
                $sql="SELECT * FROM BLOG WHERE ID=$id";
                $result=mysqli_query($link,$sql);
                $row=mysqli_fetch_assoc($result);
            } else {
                echo(mysqli_error($link));
                $message = "Somethong is worng";
            }
        }
        else
        {
            $sql="SELECT * FROM BLOG WHERE ID=$id";
            $result=mysqli_query($link,$sql);
            $row=mysqli_fetch_assoc($result);
        }
    }
}
else
{
    header("Location:login.php");
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

    <?php
        if ($message) {
        ?>
            <div class="uk-alert-success uk-text-center" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p><?php echo ($message); ?></p>
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

    <div class="uk-child-width-1-1">
        <div>
            <div class="uk-card uk-card-default">
                <div class="uk-card-media-top uk-cover-container uk-height-large">
                    <img src="<?php echo($row["Image"])?>" alt="">
                </div>
         </div>
         <br><br>
        <div class="uk-container">
            <h1 class="uk-heading-medium uk-text-center">Blog Update Form</h1>
            <form class="uk-form-stacked uk-grid-small" uk-grid action="<?php echo($_SERVER["PHP_SELF"])?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo($id);?>" name="id">
                <div class="uk-margin uk-width-1-1">
                    <label class="uk-form-label" for="form-stacked-text">Heading</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-stacked-text" type="text" placeholder="Enter Heading" value="<?php echo($row["Heading"])?>" name="heading">
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
                        <input class="uk-input" id="form-stacked-text" type="date" value="<?php echo($row["Date"])?>" name="date">
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
                            <option <?php if($row["category"]=="Option 01"){echo("selected");}?>>Option 01</option>
                            <option <?php if($row["category"]=="Option 02"){echo("selected");}?>>Option 02</option>
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
                       <textarea class="uk-textarea" rows="5" placeholder="Enter some Text About.." name="about" ><?php echo($row["About"])?></textarea>
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
                       <textarea class="uk-textarea" rows="5" placeholder="Enter Text Descriptions.." name="description" ><?php echo($row["Description"])?></textarea>
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
                        <label><input class="uk-checkbox" type="checkbox"<?php if($row["Populer"]>0) echo("checked");?> name="populer"> Yes</label>
                </div>
                
                <div class="uk-margin uk-width-1-2@s" uk-margin>
                    <div uk-form-custom="target: true">
                        <input type="file" name="blogimage">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Select Image" disabled>
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
                <button class="uk-button uk-button-primary" type="submit" name="updateblog">Update</button>
            </form>
        </div>
        </div>
        <p class="uk-text-meta uk-text-center">Created by @Ashish Kumar 22022</p>
</body>

</html>