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

      $fullname = $account_firstname." ".$account_lastname;

        $response = "<input type = 'text' name = 'account_user_id' value = '$account_user_id' hidden>";
        $response .= "<input type = 'text' name = 'fullname' value = '$fullname' hidden>";
        $response .= "<h2 style = 'font-weight:bold;'>$account_firstname $account_lastname ?</h2>";

        $response .= "<input type = 'text' name = 'faculty_user_id'  value = '$faculty_user_id' hidden>";
        $response .= "<input type = 'text' name = 'account_position' value = '$account_position' hidden>";

    }

    echo $response;
    exit;
}

?>