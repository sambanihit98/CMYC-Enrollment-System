<?php

include 'config_mysqli.php';

if(isset($_POST['account_user_id'])){
   
    $faculty_user_id = $_POST['faculty_user_id'];
    $account_user_id = $_POST['account_user_id'];

    $query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$account_user_id'");
    while($row = mysqli_fetch_array($query)){

        $account_firstname = ucwords($row['account_firstname']);
        $account_lastname  = ucwords($row['account_lastname']);
        $account_position  = ucwords($row['account_position']);
        $fullname = "$account_firstname $account_lastname";

        $response = "<h3>Are you sure you want to activate</h3>";
        $response .= "<h2 style = 'font-weight:bold;'>$fullname ?</h2><br>";
        $response .= "<input type = 'text' id = 'account_user_id' name = 'account_user_id' value = '$account_user_id' hidden>";
        $response .= "<input type = 'text' id = 'fullname' name = 'fullname' value = '$fullname' hidden>";

        $response .= "<input type = 'text' id = 'faculty_user_id' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";
        $response .= "<input type = 'text' id = 'account_position' name = 'account_position' value = '$account_position' hidden>";

        echo $response;

        exit;
    }
    
   
}

?>