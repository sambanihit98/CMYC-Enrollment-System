<?php

include 'config_mysqli.php';

if(isset($_POST['subject_id'])){

    $subject_id       = $_POST['subject_id'];
    $faculty_user_id  = $_POST['faculty_user_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
    while($row = mysqli_fetch_array($query)){

        $curriculum_id        = $row['curriculum_id'];
        $department_id        = $row['department_id'];
        $program_id           = $row['program_id'];

        $subject_code         = $row['subject_code'];
        $subject_description  = $row['subject_description'];
        $subject_year_level   = $row['subject_year_level'];
        $subject_semester     = $row['subject_semester'];
        
        $response = "<h3>Are you sure you want to archive</h3>";
        $response .= "<h2 style = 'font-weight:bold;'> $subject_description ($subject_code) ?</h2><br>";
        $response .= "<input type = 'text' id = 'subject_id'      name = 'subject_id'      value = '$subject_id'      hidden>";
        $response .= "<input type = 'text' id = 'curriculum_id'   name = 'curriculum_id'   value = '$curriculum_id'   hidden>";
        $response .= "<input type = 'text' id = 'department_id'   name = 'department_id'   value = '$department_id'   hidden>";
        $response .= "<input type = 'text' id = 'program_id   '   name = 'program_id'      value = '$program_id'      hidden>";
        $response .= "<input type = 'text' id = 'faculty_user_id' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";

        $response .= "<input type = 'text' id = 'subject_code'        name = 'subject_code'        value = '$subject_code'        hidden>";
        $response .= "<input type = 'text' id = 'subject_description' name = 'subject_description' value = '$subject_description' hidden>";
        $response .= "<input type = 'text' id = 'subject_year_level'  name = 'subject_year_level'  value = '$subject_year_level'  hidden>";
        $response .= "<input type = 'text' id = 'subject_semester'    name = 'subject_semester'    value = '$subject_semester'    hidden>";

    }
    
    echo $response;
    
    exit;
}

?>