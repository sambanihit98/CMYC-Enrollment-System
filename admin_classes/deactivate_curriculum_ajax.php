<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['curriculum_id'])){

    $faculty_user_id  = $_POST['faculty_user_id'];
    $curriculum_id    = $_POST['curriculum_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE curriculum_id = '$curriculum_id'");
    while($row = mysqli_fetch_array($query)){

        $program_id = $row['program_id'];
        $curriculum_year = $row['curriculum_year'];

        $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
        while($row_program = mysqli_fetch_array($query_program)){

            $program_code = $row_program['program_code'];

            $response = "<h3>Are you sure you want to deactivate</h3>";
            $response .= "<h2 style = 'font-weight:bold;'>$program_code - $curriculum_year ?</h2><br>";
            $response .= "<input type = 'text' id = 'curriculum_id' name = 'curriculum_id' value = '$curriculum_id' hidden>";
            $response .= "<input type = 'text' id = 'program_code' name = 'program_code' value = '$program_code' hidden>";
            $response .= "<input type = 'text' id = 'curriculum_year' name = 'curriculum_year' value = '$curriculum_year' hidden>";

            $response .= "<input type = 'text' id = 'faculty_user_id' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";


        }
    }
    
    echo $response;
    
    exit;
}

?>