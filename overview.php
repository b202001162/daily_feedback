<?php
require_once "connect.php";
require_once "header.php";

if(isset($_GET['did']))
{
    $id=$_GET['did'];
    $sql = "DELETE from overview where id = $id";
    $result = mysqli_query($dbcon, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // session_start();
    // Check if username is empty
    if (trim($_POST["id"]) > 0) {
        if (!empty(trim($_POST["description"])) && !empty(trim($_POST["course_selector"])) && !empty(trim($_POST["day_selector"])) && !empty(trim($_POST["time_selector"]))) {
            $id = trim($_POST["id"]);
            $day_selector = trim($_POST['day_selector']);
            $course_selector = trim($_POST['course_selector']);
            $time_selector = trim($_POST['time_selector']);
            $ratings_selector = trim($_POST['ratings_selector']);
            $description = trim($_POST['description']);
            $tags = trim($_POST['tags']);
            $sql = "UPDATE overview set day = $day_selector, timeslot = $time_selector, course = $course_selector, rate = $ratings_selector, description='$description', tags='$tags' where id = $id;";
            $result = mysqli_query($dbcon, $sql);
        }
        header("location: ./overview.php");
        // return;
    } else if (!empty(trim($_POST["description"])) && !empty(trim($_POST["course_selector"])) && !empty(trim($_POST["day_selector"])) && !empty(trim($_POST["time_selector"]))) {
        $day_selector = trim($_POST['day_selector']);
        $course_selector = trim($_POST['course_selector']);
        $time_selector = trim($_POST['time_selector']);
        $ratings_selector = trim($_POST['ratings_selector']);
        $description = trim($_POST['description']);
        $tags = trim($_POST['tags']);
        $sql = "insert into overview (day, timeslot, course, rate, description, tags) values($day_selector, $time_selector, $course_selector, $ratings_selector, '$description', '$tags');";
        $result = mysqli_query($dbcon, $sql);
        header("location: overview.php");
    }
    header("location: overview.php");
}
?>

<?php
//add button
echo '
<button type="button" class="btn bg-ternary-color" style="box-shadow: none; cursor: pointer; position: fixed; bottom: 50px; right: 50px; border: none;" id="add_btn">
<span class="material-symbols-outlined" style="color: var(--primary-color); font-size:35px;">
    add_notes
</span>
</button>';

// overview adder span
echo '<div class="w3-panel w3-card-2 rounded-2" id="overview_container_box" style="display: none;"> <form style="width: 95%; padding: 2px; " method="post">';
echo ' <div style="display: flex; justify-content: space-around;" id="selector_section" >
<select class="browser-default w3-card-2 custom-select rounded" id="day_selecter" name="day_selector">
    <option selected value="0"> Select Day </option>
    <option value="1"> Monday </option>
    <option value="2"> Tuesday </option>
    <option value="3"> Wednesday </option>
    <option value="4"> Thursday </option>
    <option value="5"> Friday </option>
</select>

<select class="browser-default w3-card-2 custom-select rounded" id="time_selecter" name="time_selector">
    <option selected value="0"> Select Time Slot </option>
    <option value="1"> 8:00 to 8:50 </option>
    <option value="2"> 9:00 to 9:50 </option>
    <option value="3"> 10:00 to 10:50 </option>
    <option value="4"> 11:00 to 11:50 </option>
    <option value="5"> 12:00 to 12:50 </option>
</select>

<select class="browser-default w3-card-2 custom-select rounded" id="course_selector" name="course_selector"> 
    <option selected value="0"> Select Course </option>
    <option value="1"> India through its literature </option>
    <option value="2"> introduction to cryptography </option>
    <option value="3"> Approximation Algorithms </option>
    <option value="4"> Destributed Systems </option>
    <option value="5"> Software Engineer </option>
    <option value="6"> Human Computer Interaction </option>
</select>

<select class="browser-default w3-card-2 custom-select rounded" id="ratings_selecter" name="ratings_selector">
    <option selected value="0"> Select Rating points </option>
    <option value="1"> 1 </option>
    <option value="2"> 2 </option>
    <option value="3"> 3 </option>
    <option value="4"> 4 </option>
    <option value="5"> 5 </option>
</select>
</div>
';

echo '
<div style="width: 100%; display: flex; justify-content: center; margin-top: 1em; flex-direction: column;">';
echo "<div class='form-outline mb-2'><input type='text' id='tags_input' name='tags'  class='form-control ' style='background: rgba(0,0,0,0.1);' placeholder='Tags' /> </div>";
echo "<div class='form-outline mb-4'><textarea style='color:var(--text-color); background: rgba(0,0,0,0.1);' name='description' oninput='auto_grow(this)' id='desc_input'  class='form-control' placeholder='Description'> </textarea> </div>";
echo "<div class='form-outline mb-4' style='display:none;'><textarea style='color:var(--text-color); background: rgba(0,0,0,0.1);' name='id' class='form-control' placeholder='Description' readonly> 0 </textarea> </div>";
echo '<button type="submit" class="btn btn-primary btn-block mb-4" id="login_sign_btn" style="width: 100px;">Add</button>';
echo '</form>';

echo "</div> </div>";
?>

<!-- To make visible the overview span through add_note button -->
<script>
    document.getElementById("add_btn").addEventListener("click", () => {
        // console.log("hi");
        if (document.getElementById("overview_container_box").style.display == "none") {
            document.getElementById("overview_container_box").style.display = "flex";
        }
        else {
            document.getElementById("overview_container_box").style.display = "none";
        }
    });
</script>

<?php
// COUNT

$sql = "SELECT COUNT(*) FROM overview";
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

$sql = "SELECT * FROM overview ORDER BY id DESC LIMIT $offset, $rowsperpage";
$result = mysqli_query($dbcon, $sql);

if (mysqli_num_rows($result) < 1) {
    echo '<div class="w3-panel  w3-card-2 w3-round bg-box-color text-color p-2 ps-4 px-4">No post yet!</div>';
} else {
    while ($row = mysqli_fetch_assoc($result)) {

        $id = htmlentities($row['id']);
        $day = htmlentities($row['day']);
        $timeslot = htmlentities($row['timeslot']);
        $course = htmlentities($row['course']);
        $rate = htmlentities($row['rate']);
        $tags = $row['tags'];
        $des = htmlentities(strip_tags($row['description']));
        $time = htmlentities($row['date']);
        $permalink = "./view.php?id=$id";

        echo '<div class="w3-panel w3-card-2 rounded-2" id="overview_container_box" style="display:;"> <form style="width: 95%; padding: 2px; " method="post">';
        echo ' 
        <div style="display: flex; justify-content: space-around;" id="selector_section" >
            <select class="browser-default w3-card-2 custom-select rounded selector_cls" id="day_selecter' . $id . '" name="day_selector" disabled>
        `     <option selected value="0"> Select Day </option>
                <option value="1"> Monday </option>
                <option value="2"> Tuesday </option>
                <option value="3"> Wednesday </option>
                <option value="4"> Thursday </option>
                <option value="5"> Friday </option>
            </select>

            <select class="browser-default w3-card-2 custom-select rounded selector_cls" id="time_selecter' . $id . '" name="time_selector" disabled>
                <option selected value="0"> Select Time Slot </option>
                <option value="1"> 8:00 to 8:50 </option>
                <option value="2"> 9:00 to 9:50 </option>
                <option value="3"> 10:00 to 10:50 </option>
                <option value="4"> 11:00 to 11:50 </option>
                <option value="5"> 12:00 to 12:50 </option>
            </select>

            <select class="browser-default w3-card-2 custom-select rounded selector_cls" id="course_selector' . $id . '" name="course_selector" disabled> 
                <option selected value="0"> Select Course </option>
                <option value="1"> India through its literature </option>
                <option value="2"> introduction to cryptography </option>
                <option value="3"> Approximation Algorithms </option>
                <option value="4"> Destributed Systems </option>
                <option value="5"> Software Engineer </option>
                <option value="6"> Human Computer Interaction </option>
            </select>

            <select class="browser-default w3-card-2 custom-select rounded selector_cls" id="ratings_selecter' . $id . '" name="ratings_selector" disabled>
                <option selected value="0"> Select Rating points </option>
                <option value="1"> 1 </option>
                <option value="2"> 2 </option>
                <option value="3"> 3 </option>
                <option value="4"> 4 </option>
                <option value="5"> 5 </option>
            </select>`
        </div>
        ';
        ?>
        <script>
            document.getElementById("ratings_selecter<?php echo $id; ?>").value = <?php echo $rate; ?>;
            document.getElementById("course_selector<?php echo $id; ?>").value = <?php echo $course; ?>;
            document.getElementById("time_selecter<?php echo $id; ?>").value = <?php echo $timeslot; ?>;
            document.getElementById("day_selecter<?php echo $id; ?>").value = <?php echo $day; ?>;
        </script>
        <?php

        echo '
<div style="width: 100%; display: flex; justify-content: center; margin-top: 1em; flex-direction: column;">';
        echo "<div class='form-outline mb-2'><input type='text' id='tags_input" . $id . "' name='tags'  class='form-control ' style='background: rgba(0,0,0,0.1); color: var(--text-color); font-size: larger; font-weight: 400;' placeholder='Tags' readonly value='" . $tags . "'/> </div>";
        echo "<div class='form-outline mb-4'><textarea style='color:var(--text-color); background: rgba(0,0,0,0.1);' name='description' oninput='auto_grow(this)' id='description" . $id . "'  class='form-control' placeholder='id' readonly> " . $des . " </textarea> </div>";
        echo "<div class='form-outline mb-4' style='display:none;'><textarea style='color:var(--text-color); background: rgba(0,0,0,0.1);' name='id' id='" . $id . "'  class='form-control' placeholder='Description' readonly> " . $id . " </textarea> </div>";
        echo '<button type="submit" class="btn btn-primary btn-block mb-4" id="login_sign_btn' . $id . '" style="width: 100px; display: none; background-color: rgba(0, 0, 0, 0.2);
        color: var(--text-color);
        box-shadow: none;
        border: 0px;">UPDATE</button>';
        echo '</form>';
        echo "</div>";
        echo '<div class="" style="display: flex; width: 95%;"> <button type="button" class="btn bg-box-color m-1" style="box-shadow: none;" id="edit_overview_btn' . $id . '"><span class="material-symbols-outlined" style="color: var(--ternary-color);">
        edit_note
        </span></button>';
        echo '
        <button type="button" class="btn bg-box-color m-1" data-bs-toggle="modal" data-bs-target="#exampleModal' . $id . '" style="box-shadow: none;"><span class="material-symbols-outlined" style="color: var(--ternary-color);">
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
                                                <a href="./overview.php?did=' . $id . '"><button type="button" class="btn bg-primary-color" style="box-shadow: none; color: var(--text-color);">Delete</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
        ';
        echo " </div></div>";
        ?>

        <script>
            document.getElementById("edit_overview_btn<?php echo $id; ?>").addEventListener("click", () => {
                if (document.getElementById("login_sign_btn<?php echo $id; ?>").style.display == "none") {
                    document.getElementById("login_sign_btn<?php echo $id; ?>").style.display = "initial";
                    document.getElementById("day_selecter<?php echo $id; ?>").disabled = false;
                    document.getElementById("ratings_selecter<?php echo $id; ?>").disabled = false;
                    document.getElementById("course_selector<?php echo $id; ?>").disabled = false;
                    document.getElementById("time_selecter<?php echo $id; ?>").disabled = false;
                    document.getElementById("tags_input<?php echo $id; ?>").readOnly = false;
                    document.getElementById("description<?php echo $id; ?>").readOnly = false;
                }
                else {
                    document.getElementById("login_sign_btn<?php echo $id; ?>").style.display = "none";
                    document.getElementById("day_selecter<?php echo $id; ?>").disabled = true;
                    document.getElementById("ratings_selecter<?php echo $id; ?>").disabled = true;
                    document.getElementById("course_selector<?php echo $id; ?>").disabled = true;
                    document.getElementById("time_selecter<?php echo $id; ?>").disabled = true;
                    document.getElementById("tags_input<?php echo $id; ?>").readOnly = true;
                    document.getElementById("description<?php echo $id; ?>").readOnly = true;
                }
            });
        </script>


        <?php
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