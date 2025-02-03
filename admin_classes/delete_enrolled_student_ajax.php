<?php 

include 'config_mysqli.php';

if(isset($_POST['enrollment_id'])){
    
    $faculty_user_id = $_POST['faculty_user_id'];
    $enrollment_id   = $_POST['enrollment_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_enrollment JOIN academic_year ON manage_enrollment.academic_id = academic_year.academic_id
                                  WHERE manage_enrollment.enrollment_id = '$enrollment_id'");
    while($row = mysqli_fetch_array($query)){
      
     // manage_enrollment table
      $firstname       = $row['student_firstname'];
      $lastname        = $row['student_lastname'];
      $middlename      = $row['student_middlename'];
      $name_extension  = $row['student_name_extension'];

      $middle_initial = substr($middlename, 0,1);

      //academic_year table
      $academic_id         = $row['academic_id'];
      $academic_year_from  = $row['academic_year_from'];
      $academic_year_to    = $row['academic_year_to'];
      $academic_term       = $row['academic_term'];

      $academic_year       = $academic_year_from." - ".$academic_year_to." "."($academic_term)";
      $fullname = $firstname." ".$middle_initial.". ".$lastname." ".$name_extension;

        $response  = "<input type = 'text' name = 'enrollment_id'   value = '$enrollment_id'   hidden>";
        $response .= "<input type = 'text' name = 'fullname'        value = '$fullname'        hidden>";
        $response .= "<input type = 'text' name = 'academic_year'   value = '$academic_year'   hidden>";
        $response .= "<input type = 'text' name = 'academic_id'     value = '$academic_id'     hidden>";
        $response .= "<input type = 'text' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";

    }

    echo $response;
    exit;
}

?>