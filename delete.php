<?php
require_once "./header.php";
require_once "./connect.php";

if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $sql = "delete from daily_posts where id = $id";
    $result = mysqli_query($dbcon, $sql);
    header("location: ./index.php");
}

?>