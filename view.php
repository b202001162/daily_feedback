<?php
require_once 'connect.php';
require_once 'header.php';

$id = (INT)$_GET['id'];
if ($id < 1) {
    header("location: $url_path");
}
$sql = "Select * FROM daily_posts WHERE id = '$id'";
$result = mysqli_query($dbcon, $sql);

$invalid = mysqli_num_rows($result);
if ($invalid == 0) {
    header("location: $url_path");
}

$hsql = "SELECT * FROM daily_posts WHERE id = '$id'";
$res = mysqli_query($dbcon, $hsql);
$row = mysqli_fetch_assoc($result);

$id = $row['id'];
$title = $row['title'];
$description = $row['description'];
$time = $row['date'];

echo '<div class="w3-container ">';

echo "<h3 style='color: var(--ternary-color);'>$title</h3>";
echo '<div class="w3-panel " style="color: var(--text-color);">';
echo "$description<br>";
echo '<div class="" style="color:var(--outcast-color);">';
echo "Posted on: $time</div>";
echo '</div></div>';
?>
