<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['academic_id'])){

    $faculty_user_id = $_POST['faculty_user_id'];
    $academic_id     = $_POST['academic_id'];

    $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
    while($row = mysqli_fetch_array($query)){

        $id = $row['academic_id'];
        $academic_year_from = $row['academic_year_from'];
        $academic_year_to = $row['academic_year_to'];
        $academic_term = $row['academic_term'];
           

        $response = "<h3>Are you sure you want to activate</h3>";
        $response .= "<h2 style = 'font-weight:bold;'>$academic_year_from - $academic_year_to ($academic_term) ?</h2><br>";
        $response .= "<input type = 'text' id = 'academic_id' name = 'academic_id' value = '$id' hidden>";
        $response .= "<input type = 'text' id = 'faculty_user_id' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";

        $response .= "<input type = 'text' id = 'academic_year_from' name = 'academic_year_from' value = '$academic_year_from' hidden>";
        $response .= "<input type = 'text' id = 'academic_year_to'   name = 'academic_year_to'   value = '$academic_year_to' hidden>";
        $response .= "<input type = 'text' id = 'academic_term'      name = 'academic_term'      value = '$academic_term' hidden>";

    }
    
    echo $response;
    
    exit;
}

?>