<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['department_id'])){

    $faculty_user_id = $_POST['faculty_user_id'];
    $department_id   = $_POST['department_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
    while($row = mysqli_fetch_array($query)){

        $department_code         = $row['department_code'];
        $department_description  = $row['department_description'];

        $response = "<h3>Are you sure you want to archive</h3>";
        $response .= "<h2 style = 'font-weight:bold;'> $department_description ($department_code) ?</h2><br>";
        $response .= "<input type = 'text' id = 'department_id'          name = 'department_id'          value = '$department_id'          hidden>";
        $response .= "<input type = 'text' id = 'faculty_user_id'        name = 'faculty_user_id'        value = '$faculty_user_id'        hidden>";
        $response .= "<input type = 'text' id = 'department_code'        name = 'department_code'        value = '$department_code'        hidden>";
        $response .= "<input type = 'text' id = 'department_description' name = 'department_description' value = '$department_description' hidden>";
       
    }
    
    echo $response;
    
    exit;
}

?>