<?php
require_once "connect.php";
session_start();
if(isset($_GET["id"]))
{
    $id=$_GET["id"];
    $sql="DELETE FROM BLOG WHERE id=$id";
    $sql2="DELETE FROM COMMENT WHERE blogid=$id";
    if(mysqli_query($link,$sql))
    {   
       $_SESSION["delete"]="Blog is successfully deleted";
       mysqli_query($link,$sql2);
       header("Location:admin.php");
    }
    else
    {
        $_SESSION["undelete"]="Blog is not match";
        header("Location:admin.php");
        
    }
}
?>