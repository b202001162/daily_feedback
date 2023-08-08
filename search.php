<?php
require_once 'connect.php';
require_once 'header.php';

if (isset($_GET['q'])) {
  $q = mysqli_real_escape_string($dbcon, $_GET['q']);

  $sql = "SELECT * FROM daily_posts WHERE tags like '%{$q}%' or title LIKE '%{$q}%' OR description LIKE '%{$q}%'";
  $result = mysqli_query($dbcon, $sql);

  if (mysqli_num_rows($result) < 1) {
    echo "Nothing found.";
  } else {

    echo "<div class='w3-container w3-padding' style='color: var(--text-color); font-size: 18px;'>Showing results for <b>'$q'</b></div>";

    while ($row = mysqli_fetch_assoc($result)) {

      $id = htmlentities($row['id']);
      $title = htmlentities($row['title']);
      $des = htmlentities(strip_tags($row['description']));
      $time = htmlentities($row['date']);

      $permalink = "./view.php?id=$id";

      echo '<div class="w3-panel w3-card-4" id="post_container_box">';
      echo "<h3><a href='$permalink' style='color:var(--ternary-color);'>$title</a></h3><p>";

      echo "<p style='color:var(--text-color);' >" . substr($des, 0, 500) . "...</p>";

      echo '</p><div class="w3-text-teal">';
      echo "<a href='$permalink' style='color: var(--ternary-color);'>Read more...</a>";

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
    echo "</div>";

  }
}