<?php 
require_once "connect.php";
if(isset($_GET["id"]))
{   
    session_start();
    $id=$_GET["id"];
    $sql="DELETE FROM USER WHERE ID=$id";
    if(mysqli_query($link,$sql))
    {   
        if ($id==$_SESSION["id"])
        {
            unset($_SESSION["username"]);
            unset($_SESSION["id"]);
            unset($_SESSION["email"]);
            $_SESSION["delete"]="User successfuly delete";
            header("Location:login.php");
        }
        else
        {
        $_SESSION["delete"]="User successfuly delete";
        header("Location:admin.php");
        }
    }
    else
    {
        $_SESSION["undelete"]="Somthing is worng to delete user";
        header("Location:admin.php");
    }
}
