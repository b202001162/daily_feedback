<?php
require_once 'connect.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // session_start();
    // Check if username is empty
    if (!empty(trim($_POST["description"])) || !empty(trim($_POST["title"]))) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $id = trim($_POST['id']);
        $tags = trim($_POST['tags']);
        $sql = "UPDATE daily_posts set title ='$title', description = '$description', tags = '$tags'  where id =  '$id';";
        $result = mysqli_query($dbcon, $sql);
        header("location: index.php");
    }
    header("location: index.php");
}

$id = (INT) $_GET['id'];
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
$tags = $row['tags'];

echo '<div class="w3-panel w3-card-4" id="post_container_box">';
echo '<form style="width: 95%;" method="post">';
echo "<div class='form-outline mb-2'><input type='text' id='title_input' name='title'  class='form-control'/> </div>";
echo "<div class='form-outline mb-2'><input type='text' id='tags_input' name='tags'  class='form-control ' /> </div>";
// echo "<h3 style='color: var(--ternary-color);'>$title</h3>";
// echo '<div class="w3-panel " style="color: var(--text-color);">';
echo "<div class='form-outline mb-4'><textarea style='color:var(--text-color);' name='description' oninput='auto_grow(this)' id='desc_input'  class='form-control'> </textarea> </div>";
echo "<div class='form-outline mb-2'><input style='color:var(--text-color); display: none;' name='id' id='id_input'  class='form-control'> </input> </div>";
echo '<button type="submit" class="btn btn-primary btn-block mb-4" id="login_sign_btn" style="width: 100px;">Update</button>';
echo '</form></div>';
?>

<script>

    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
    }

    document.getElementById("desc_input").value = "<?php echo $description; ?>";
    document.getElementById("title_input").value = "<?php echo $title; ?>";
    document.getElementById("id_input").value = "<?php echo $id; ?>";
    document.getElementById("tags_input").value = "<?php echo $tags; ?>";
    console.log("<?php echo $description; ?>");
</script>