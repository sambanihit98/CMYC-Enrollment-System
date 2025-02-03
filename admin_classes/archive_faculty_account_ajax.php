<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['account_user_id'])){

    $faculty_user_id = $_POST['faculty_user_id'];
    $account_user_id = $_POST['account_user_id'];

    $query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$account_user_id'");
    while($row = mysqli_fetch_array($query)){

        $account_user_id     = $row['account_user_id'];
        $account_firstname   = $row['account_firstname'];
        $account_lastname    = $row['account_lastname'];
        $account_position    = $row['account_position'];

        $fullname = $account_firstname.' '.$account_lastname;

        $response = "<h3>Are you sure you want to archive</h3>";
        $response .= "<h2 style = 'font-weight:bold;'> $fullname ($account_position) ?</h2><br>";
        $response .= "<input type = 'text' id = 'account_user_id' name = 'account_user_id' value = '$account_user_id' hidden>";
        $response .= "<input type = 'text' id = 'faculty_user_id' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";
        $response .= "<input type = 'text' id = 'fullname'        name = 'fullname'        value = '$fullname'        hidden>";
        $response .= "<input type = 'text' id = 'account_position'name = 'account_position'value = '$account_position'hidden>";

    }
    
    echo $response;
    
    exit;
}

?>