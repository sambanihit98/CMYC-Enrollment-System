<?php 

include '../admin_classes/config_mysqli.php';
   
	$faculty_user_id  = $_POST['faculty_user_id'];
	$student_id       = $_POST['student_id'];
	$year_level       = $_POST['year_level'];
	$term             = $_POST['term'];
	$period           = $_POST['period'];
	$program_id       = $_POST['program_id'];

		//manage_enrollment table
		$query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment 
			WHERE student_id = '$student_id' 
			AND student_year_level = '$year_level'
			AND student_semester = '$term'
			AND program_id = '$program_id'");

if (mysqli_num_rows($query_enrollment)>0){
		echo json_encode(array("statusCode"=>201));

}else{  
        echo json_encode(array("statusCode"=>200));

}







 ?>