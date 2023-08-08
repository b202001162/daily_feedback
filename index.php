<?php
require_once 'connect.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // session_start();
    // Check if username is empty
    if (!empty(trim($_POST["description"])) && !empty(trim($_POST["title"]))) {
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


<!-- <script>
    var tags = "";
    // var tagsArray = tags.split(', ');
    // console.log(tagsArray);
</script> -->

<?php

echo '
<button type="button" class="btn bg-ternary-color" style="box-shadow: none; cursor: pointer; position: fixed; bottom: 50px; right: 50px; border: none;" id="add_btn">
<span class="material-symbols-outlined" style="color: var(--primary-color); font-size:35px;">
    add_notes
</span>
</button>';

echo '<div class="w3-panel w3-card-4 rounded-2" id="container_box_new_post" style="display: none;">';
echo '<form style="width: 97%;" method="post">';
echo "<div class='form-outline mb-2'><input type='text' id='title_input' name='title'  class='form-control ' style='background: rgba(0,0,0,0.1); ' placeholder='Title'/> </div>";
echo "<div class='form-outline mb-2'><input type='text' id='tags_input' name='tags'  class='form-control ' style='background: rgba(0,0,0,0.1);;' placeholder='Tags' /> </div>";
echo "<div class='form-outline mb-4'><textarea style='color:var(--text-color); background: rgba(0,0,0,0.1);' name='description' oninput='auto_grow(this)' id='desc_input'  class='form-control' placeholder='Description'> </textarea> </div>";
echo '<button type="submit" class="btn btn-primary btn-block mb-4" id="login_sign_btn" style="width: 100px;">Add</button>';
echo '</form> </div>';
?>

<script>
    let new_post_container = document.getElementById("container_box_new_post")[0];
    document.getElementById("add_btn").addEventListener("click", () => {
        // console.log("hi");
        if (document.getElementById("container_box_new_post").style.display == "none") {
            document.getElementById("container_box_new_post").style.display = "flex";
        }
        else {
            document.getElementById("container_box_new_post").style.display = "none";
        }
    });
</script>

<?php
// COUNT

$sql = "SELECT COUNT(*) FROM daily_posts";
$result = mysqli_query($dbcon, $sql);
$r = mysqli_fetch_row($result);
$numrows = $r[0];

$rowsperpage = PAGINATION;
$totalpages = ceil($numrows / $rowsperpage);

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (INT) $_GET['page'];
}

if ($page > $totalpages) {
    $page = $totalpages;
}

if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $rowsperpage;

$sql = "SELECT * FROM daily_posts ORDER BY id DESC LIMIT $offset, $rowsperpage";
$result = mysqli_query($dbcon, $sql);

if (mysqli_num_rows($result) < 1) {
    echo '<div class="w3-panel  w3-card-2 w3-round bg-box-color text-color p-2 ps-4 px-4">No post yet!</div>';
} else {
    while ($row = mysqli_fetch_assoc($result)) {

        $id = htmlentities($row['id']);
        $title = htmlentities($row['title']);
        $des = htmlentities(strip_tags($row['description']));
        $tags = htmlentities($row['tags']);
        // $slug = htmlentities($row['slug']);
        $time = htmlentities($row['date']);
        $permalink = "./view.php?id=$id";

        echo '<div class="w3-panel w3-card-4 rounded-2" id="post_container_box">';
        if ($tags != '')
            echo "<div class='w3-card bg-secondary-color p-2 mb-2 rounded'><p style='color:var(--ternary-color); font-size: medium; margin:0;'>Tags: " . $tags . "</p></div>";
        echo "<h3><a href='$permalink' style='color: var(--outcast-color);'>$title</a></h3><p>";
        echo "<p style='color:var(--text-color);'>" . substr($des, 0, 200) . "...</p>";

        echo '<div class="w3-text-teal">';
        echo "<a href='$permalink' style='color: var(--ternary-color);'>Read more...</a></p>";

        echo '</div>';
        echo "<div class=''  style='color: var(--outcast-color); font-weight: 500; font-size: small;'> $time </div>";
        echo '<a href="./edit.php?id=' . $id . '" style="cursor: pointer;"><button type="button" class="btn bg-box-color mt-2" style="box-shadow: none;"><span class="material-symbols-outlined" style="color: var(--ternary-color);">
        edit_note
        </span></button> </a>';
        echo '
        <button type="button" class="btn bg-box-color mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal' . $id . '" style="box-shadow: none;"><span class="material-symbols-outlined" style="color: var(--ternary-color);">
                            delete_forever
                            </span></button>
        <!-- Modal -->
                            <div class="modal fade" id="exampleModal' . $id . '" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-secondary-color">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-color" id="exampleModalLabel">Are you want to delete it permanent!</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary text-color"
                                                data-bs-dismiss="modal">Cancel</button>
                                                <a href="./delete.php?id=' . $id . '"><button type="button" class="btn bg-primary-color" style="box-shadow: none; color: var(--text-color);">Delete</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
        ';
        echo '</div>';
    }


    echo "<p><div class='w3-bar w3-center' id='footer_slider'>";

    if ($page > 1) {
        echo "<a href='?page=1' class='w3-btn' style='background-color: var(--primary-color); color:var(--ternary-color); margin-right:5px;'>&laquo;</a>";
        $prevpage = $page - 1;
        echo "<a href='?page=$prevpage' class='w3-btn' style='background-color: var(--primary-color); color:var(--ternary-color); margin-right:5px;'><</a>";
    }

    $range = 5;
    for ($x = $page - $range; $x < ($page + $range) + 1; $x++) {
        if (($x > 0) && ($x <= $totalpages)) {
            if ($x == $page) {
                echo "<div class='w3-button' style='background-color:var(--outcast-color); color:var(--primary-color); margin-right:5px;'>$x</div>";
            } else {
                echo "<a href='?page=$x' class='w3-button' style='background-color: var(--primary-color); color:var(--ternary-color); margin-right:5px;'>$x</a>";
            }
        }
    }

    if ($page != $totalpages) {
        $nextpage = $page + 1;
        echo "<a href='?page=$nextpage' class='w3-button' style='background-color: var(--primary-color); color:var(--ternary-color); margin-right:5px;'>></a>";
        echo "<a href='?page=$totalpages' class='w3-btn' style='background-color: var(--primary-color); color:var(--ternary-color); margin-right:5px;'>&raquo;</a>";
    }
    echo "</div></p>";
}
echo "</div>";
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>