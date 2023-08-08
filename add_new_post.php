<?php
require_once "connect.php";
require_once "header.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // session_start();
    // Check if username is empty
    if (!empty(trim($_POST["description"])) && !empty(trim($_POST["title"])) ) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $tags = trim($_POST['tags']);
        $sql = "insert into daily_posts (title, description, tags) values('$title', '$description', '$tags');";
        $result = mysqli_query($dbcon, $sql);
        header("location: index.php");
    }
    header("location: index.php");
}

?>

<?php
echo '<div class="w3-panel w3-card-4" id="post_container_box container_box_new_post">';
echo '<form style="width: 97%;" method="post">';
echo "<div class='form-outline mb-2'><input type='text' id='title_input' name='title'  class='form-control ' style='background: rgba(0,0,0,0.1); ' placeholder='Title'/> </div>";
echo "<div class='form-outline mb-2'><input type='text' id='tags_input' name='tags'  class='form-control ' style='background: rgba(0,0,0,0.1);;' placeholder='Tags' /> </div>";
echo "<div class='form-outline mb-4'><textarea style='color:var(--text-color); background: rgba(0,0,0,0.1);' name='description' oninput='auto_grow(this)' id='desc_input'  class='form-control' placeholder='Description'> </textarea> </div>";
echo '<button type="submit" class="btn btn-primary btn-block mb-4" id="login_sign_btn" style="width: 100px;">Add</button>';
echo '</form> </div>';