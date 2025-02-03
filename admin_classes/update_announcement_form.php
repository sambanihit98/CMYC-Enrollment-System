<?php

include 'config_mysqli.php';

if(isset($_POST['announcement_id'])){

    $announcement_id = $_POST['announcement_id'];

    $query = mysqli_query($con, "SELECT * FROM announcements WHERE  announcement_id = '$announcement_id'");
      while ($row = mysqli_fetch_array($query)){
      $announcement = $row['announcement'];
      $link         = $row['link'];

      $response = "

                <div class = 'row'>
                  <div class='col-sm'>
                      <label style = 'float:left;'><b>Announcement:</b></label>
                      <textarea class='form-control border border-secondary rounded input-sm' id = 'announcement_new' style='resize: none; height:200px;'>$announcement</textarea>                               
                  </div>
                </div>
                <br>
                <div class = 'row'>
                  <div class='col-sm'>
                      <label style = 'float:left;'><b>Link:</b></label>
                      <textarea class='form-control border border-secondary rounded input-sm' id = 'link_new' style='resize: none; height:100px;'>$link</textarea>                               
                  </div>
                </div>

          ";

          $response .= "<input type = 'text' id = 'announcement_id_hid' name = 'announcement_id_hid' value = '$announcement_id' hidden>";
          

}
    echo $response;
    exit;
    
}



?>