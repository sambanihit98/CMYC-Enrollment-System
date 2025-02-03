<?php

include 'config_mysqli.php';

if(isset($_POST['department_id'])){

    $department_id = $_POST['department_id'];

   $query = mysqli_query($con, "SELECT * FROM manage_department WHERE  department_id = '$department_id'");
while ($row = mysqli_fetch_array($query)){
$department_code = $row['department_code'];
$department_description = $row['department_description'];

$response = "

            <div class = 'row'>                    
                <div class = 'col-lg-12'>
                    <label class='text-dark' style='font-weight: bold;'>DEPARTMENT CODE</label>
                    <input type = 'text' class = 'form-control' id = 'department_code_update' name = 'department_code' value = '$department_code'>
                </div>
            </div>
            <br>
            <div class = 'row'>                    
                <div class = 'col-lg-12'>
                    <label class='text-dark' style='font-weight: bold;'>DESCRIPTION</label>
                    <input type = 'text' class = 'form-control' id = 'department_description_update' name = 'department_description' value = '$department_description'>
                </div>               
            </div>
            <br>    

           
    ";

    $response .= "<input type = 'text' id = 'department_id_hid' name = 'department_id' value = '$department_id' hidden>";
    $response .= "<input type = 'text' id = 'department_code_hid' name = 'department_code' value = '$department_code' hidden>";
    $response .= "<input type = 'text' id = 'department_description_hid' name = 'department_description' value = '$department_description' hidden>";

}
    echo $response;
    exit;
    
}



?>