
<?php

include '../admin_classes/config_mysqli.php';

$faculty_user_id  = $_POST['faculty_user_id'];
$department_id    = $_POST['department_id'];

$query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
while($row = mysqli_fetch_array($query)){
    $department_code = $row['department_code'];
    $department_description = $row['department_description'];

    $department = $department_description." "."("."$department_code".")";

    //data for user log table

$user_action      = 'Deleted <b>'.$department_description.' '.'('.$department_code.')</b>'.' department';
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;

}

mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

mysqli_query($con, "DELETE FROM manage_department WHERE department_id = '$department_id'");

header("location:../registrar_manage_department.php?deleted&department=$department");

?>






