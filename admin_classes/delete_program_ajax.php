<?php 

include '../admin_classes/config_mysqli.php';

if(isset($_POST['program_id'])){
    
    $faculty_user_id  = $_POST['faculty_user_id'];
    $program_id       = $_POST['program_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
    while($row = mysqli_fetch_array($query)){
        $program_id          = $row['program_id'];
        $department_id       = $row['department_id'];

        $response = "<input  type = 'text' name = 'program_id'      value = '$program_id'      hidden>";
        $response .= "<input type = 'text' name = 'department_id'   value = '$department_id'   hidden>";
        $response .= "<input type = 'text' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";
    }

    echo $response;
    exit;
}

?>