<?php 

include '../admin_classes/config_mysqli.php';

if(isset($_POST['department_id'])){
    
    $faculty_user_id = $_POST['faculty_user_id'];
    $department_id   = $_POST['department_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
    while($row = mysqli_fetch_array($query)){
        $department_id          = $row['department_id'];


        $response = "<input type = 'text' name = 'department_id' value = '$department_id' hidden>";
        $response .= "<input type = 'text' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";

    }

    echo $response;
    exit;
}

?>