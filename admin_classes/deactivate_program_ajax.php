<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['program_id'])){

    $faculty_user_id  = $_POST['faculty_user_id'];
    $program_id       = $_POST['program_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
    while($row = mysqli_fetch_array($query)){

        $program_id = $row['program_id'];
        $program_code = $row['program_code'];
        $program_description = $row['program_description'];


        $response = "<h3>Are you sure you want to deactivate</h3>";
        $response .= "<h2 style = 'font-weight:bold;'>$program_description ($program_code) ?</h2><br>";
        $response .= "<input type = 'text' id = 'program_id' name = 'program_id' value = '$program_id' hidden>";

        $response .= "<input type = 'text' id = 'program_code'        name = 'program_code'        value = '$program_code' hidden>";
        $response .= "<input type = 'text' id = 'program_description' name = 'program_description' value = '$program_description' hidden>";
        $response .= "<input type = 'text' id = 'faculty_user_id'     name = 'faculty_user_id'     value = '$faculty_user_id' hidden>";

    }
    
    echo $response;
    
    exit;
}

?>