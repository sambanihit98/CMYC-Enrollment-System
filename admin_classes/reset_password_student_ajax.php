<?php 

include 'config_mysqli.php';

if(isset($_POST['student_id'])){
    
    $faculty_user_id = $_POST['faculty_user_id'];
    $student_id      = $_POST['student_id'];

    $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
    while($row = mysqli_fetch_array($query)){
        $student_id = $row['student_id'];
        $firstname  = ucwords($row['firstname']);
        $middlename = ucwords($row['middlename']);
        $lastname   = ucwords($row['lastname']);

        $middle_initial = substr($middlename, 0, 1);

        $fullname = $firstname.' '.$middle_initial.'. '.$lastname;

        $response =  "<input type = 'text' name = 'student_id' value = '$student_id' hidden>";
        $response .= "<h2 style = 'font-weight:bold;'>$firstname $middle_initial. $lastname?</h2>";

        $response .= "<input type = 'text' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";
        $response .= "<input type = 'text' name = 'fullname'        value = '$fullname'        hidden>";
    }

    echo $response;
    exit;
}

?>