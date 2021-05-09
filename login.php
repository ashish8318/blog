<?PHP
require_once "connect.php";
session_start();
$email = $password ='';
$email_error = $password_error ='';
if (isset($_POST["submit"])) {
    
    if (empty($_POST["email"])) {
        $email_error = "Email required";
    } else {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["email"];
        } else {
            $email_error = "Invalid email";
        }
    }

    if (empty($_POST["password"])) {
        $passwprd_error = "Password required";
    } 
    else {
        $password = $_POST["password"];
    }

    if ((empty($email_error) && empty($password_error))) {
        $sql1="SELECT EMAIL, PASSWORD, USERNAME,ID FROM USER WHERE EMAIL='$email'";
        if($result=mysqli_query($link,$sql1))
        {
            if(mysqli_num_rows($result)>0)
            {
                $row=mysqli_fetch_assoc($result);
                $hash=$row["PASSWORD"];
                
                if (password_verify($password,$hash))
                {   
                    session_start();
                    $_SESSION["id"]=$row["ID"];
                    $_SESSION["username"]=$row["USERNAME"];
                    $_SESSION["email"]=$row["EMAIL"];
                    header("Location:index.php"); 
                }
                else
                {
                  $password_error="Worng password";
                }
            }
            else
            {   
                $email_error="Email not match please register";
             }
        }
        
    }
    echo(mysqli_error($link));
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
    <div class="uk-child-width-expand@s uk-position-center" uk-grid>
        <div>
            <img src="image/undraw_Login_re_4vu2.svg">
        </div>
        <div>
            <form action="<?php echo($_SERVER["PHP_SELF"])?>" method="POST" novalidate>
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend">User Login</legend>

                    <div class="uk-margin">
                        <input class="uk-input" type="email" placeholder=" Enter Email" name="email">
                        <?php
                        if ($email_error)
                        {
                        ?>
                        <div class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p><?php echo($email_error)?></p>
                        </div> 
                        <?php
                        } 
                        ?>
                    </div>

                    <div class="uk-margin">
                        <input class="uk-input" type="password" placeholder=" Ente password" name="password">
                        <?php
                        if ($password_error)
                        {
                        ?>
                        <div class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p><?php echo($password_error)?></p>
                        </div> 
                        <?php
                        } 
                        ?>
                    </div>

                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary" type="submit" name="submit">Login</button>
                        <br>
                        <p> You have not account register now <a href="register.php">Register</a></p>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <p class="uk-text-meta uk-text-center uk-position-bottom">Created by @Ashish Kumar 22022</p>
</body>

</html>