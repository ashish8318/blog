<?php
// include connect.php
require_once "connect.php";
$username = $email = $password ='';
$username_error = $email_error = $passwprd_error ='';
if (isset($_POST["submit"])) {
    if (empty($_POST["username"])) {
        $username_error = "Name is required";
    } else {
        if (!preg_match("/^[a-zA-z]*$/",$_POST["username"])) 
        {
            $username_error = "Only letter or white space allowed";
            
        } else {
            $username = trim($_POST["username"]);
            
        }
    }

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

    if ((empty($username_error)&& empty($email_error) && empty($password_error))) {
        $sql1="SELECT EMAIL FROM USER WHERE EMAIL='$email'";
        if($result=mysqli_query($link,$sql1))
        {
            if(mysqli_num_rows($result)>0)
            {
                $email_error="Email is already exits";
            }
            else
            {   
                $hashpassword=password_hash($password,PASSWORD_DEFAULT);
                $sql = "INSERT INTO USER VALUES('$username','$email','$hashpassword',null,'')";
                  if (mysqli_query($link,$sql)) {
                     header("Location:http://localhost/blog/login.php");
                 
               } 
               else {
                  $email_error="Something is worng";
                  }
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
    <div class="uk-child-width-expand@s uk-position-center" uk-grid>
        <div>
            <img src="image/undraw_Sign_in_re_o58h.svg">
        </div>
        <div>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" novalidate>
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend">User Register</legend>

                    <div class="uk-margin">
                        <input class="uk-input" type="text" placeholder="Enter Name" name="username">
                        <?php
                        if ($username_error)
                        {
                        ?>
                        <div class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p><?php echo($username_error)?></p>
                        </div> 
                        <?php
                        } 
                        ?>
                        
                    </div>

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
                        if ($passwprd_error)
                        {
                        ?>
                        <div class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <p><?php echo($passwprd_error)?></p>
                        </div> 
                        <?php
                        } 
                        ?>

                    </div>

                    <div class="uk-margin">
                        <button class="uk-button uk-button-primary" type="submit" name="submit">Register</button>
                        <p> You have not already account login now <a href="login.php">Login</a></p>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <p class="uk-text-meta uk-text-center uk-position-bottom">Created by @Ashish Kumar 22022</p>
</body>

</html>