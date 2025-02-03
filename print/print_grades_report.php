<?php
  include '../admin_classes/config_mysqli.php';

	$faculty_user_id  = $_GET['faculty'];
	$student_id       = $_GET['student_id'];
	$year_level       = $_GET['year_level'];
	$term             = $_GET['term'];
	$period           = $_GET['period'];
	$program_id       = $_GET['program_id'];

  //-------------------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------------------
	//STUDENT INFO
  $query_student  = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
  $row_student    = mysqli_fetch_array($query_student);

	$firstname      = $row_student['firstname'];
	$middlename     = $row_student['middlename'];
	$lastname       = $row_student['lastname'];
	$name_extension = $row_student['name_extension'];

	$middle_initial = substr($middlename, 0, 1);
	$fullname       = "$firstname $middle_initial. $lastname";

	//-------------------------------------------------------------------------------------------------------
  //-------------------------------------------------------------------------------------------------------
	//FACULTY INFO
  $query_faculty  = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$faculty_user_id'");
  $row_faculty    = mysqli_fetch_array($query_faculty);

	$faculty_firstname      = $row_faculty['account_firstname'];
	$faculty_lastname       = $row_faculty['account_lastname'];
	$faculty_position       = $row_faculty['account_position'];
	$faculty_fullname       = "$faculty_firstname $faculty_lastname";

	//-------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------
	//PROGRAM
	$query_program  = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
	$row_program    = mysqli_fetch_array($query_program);

	$program_code   = $row_program['program_code'];
	$program_desc   = $row_program['program_description'];

	//-------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------

	//manage_enrollment table
	$query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment 
		WHERE student_id = '$student_id' 
		AND student_year_level = '$year_level'
		AND student_semester = '$term'
		AND program_id = '$program_id'");

			while($row_enrollment = mysqli_fetch_array($query_enrollment)){
				$enrollment_id      = $row_enrollment['enrollment_id'];
				$academic_id        = $row_enrollment['academic_id'];
				$student_section    = $row_enrollment['student_section'];
				$student_year_level = $row_enrollment['student_year_level'];

				if($student_year_level == 1){
					$year_level = '1st Year';
				}else if($student_year_level == 2){
					$year_level = '2nd Year';
				}else if($student_year_level == 3){
					$year_level = '3rd Year';
				}else if($student_year_level == 4){
					$year_level = '4th Year';
				}

			}

	//-------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------

	$query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
	$row_academic = mysqli_fetch_array($query_academic);
	
	$academic_year_from = $row_academic['academic_year_from'];
	$academic_year_to   = $row_academic['academic_year_to'];
	$academic_term      = $row_academic['academic_term'];

	$academic_year = "$academic_year_from-$academic_year_to ($academic_term)";

	//-------------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------


?>

<!DOCTYPE html>
  <html>
    <head>
      <title></title>
    </head>
    <body onload="window.print();" >

      <!----HEAD---->
      <table style="margin-left: 1%">
        <tr style="border: none;">
          <th><img src="../img/m_logo.jpg" style="width: 100px; margin-left: 10px;"></th>
          <th style="font-size: 30px;"> CATHOLIC MING YUAN COLLEGE 

            <p style="font-size: 15px; margin-left: -40px; margin-top: -5px;"> Hda Binitin Murcia, Negros Occidental Philippines</p> 

            <p style="font-size: 15px; margin-left: -45px; margin-top: -17px; color: blue;" >mingyuancollege@gmail.com | (034) 4413570</p>

          </th>
        </tr>
      </table>
      <!----HEAD---->
      <hr>

      <table style="margin-bottom: 50px;">
        <tr>
          <td style="width: 50%;"> 
						<b>Name:</b> <?php echo $fullname; ?>  <br> 
						<b>Program: </b><?php echo $program_desc; ?> 
						<b>Section: </b><?php echo $student_section; ?>
					</td>

          <td style="width: 30%;">
						<b>ID Number:</b> <?php echo $student_id; ?> <br>
						<b>Year Level: </b><?php echo $year_level; ?> <br>
						<b>A.Y.: </b><?php echo $academic_year; ?>
						
					</td>
		  
        </tr>
      </table>

			<h3 style="text-align: center; margin-top: -10px; margin-bottom: -10px;"><?php echo $period; ?> Grades</h3><br>
      <hr style="margin-bottom: -1px;">

          <?php 

						print "
							<table style = 'width:100%;'>
								<thead style = 'text-align:center;font-size: 14px;'>
									<th>Subject Code</th>
									<th>Subject Description</th>
									<th>Credit</th>
									<th>Teacher</th>
									<th>Grade</th>
									<th>Remarks</th>
								</thead>
								<tbody style='font-size: 12px;'>";

									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//PRELIM
									if($period == "Prelim"){

										$query4 = mysqli_query($con, "SELECT * FROM grades_report 
											JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id 
											WHERE grades_report.enrollment_id = '$enrollment_id'");

								

											while($row4 = mysqli_fetch_array($query4)){
												
												//manage_subject table
												$subject_id           = $row4['subject_id'];
												$subject_code         = $row4['subject_code'];
												$subject_description  = $row4['subject_description'];
												$subject_unit         = $row4['subject_unit'];

												//grades_report table
												$grades_report_id = $row4['grades_report_id'];
												$prelim           = $row4['prelim'];
												$grades_section   = $row4['grades_section'];
												$remarks          = $row4['remarks'];


												print "<tr style = 'text-align:center;'>";

												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------
												
												print "
														<td class = 'table_data'>$subject_code</td>
														<td class = 'table_data'>$subject_description</td>
														<td class = 'table_data'>$subject_unit</td>";
												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												// checks if there is a teacher aasigned to this subject and section
												$query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
												JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
												WHERE teacher_subject_load.subject_id = '$subject_id'
												AND teacher_subject_load.subject_section = '$grades_section'
												AND teacher_subject_load.academic_id = '$academic_id'");

												if(mysqli_num_rows($query_teacher_schedule)>0){
													$row_teacher = mysqli_fetch_array($query_teacher_schedule);

														//teacher name
														$account_firstname  = ucwords($row_teacher['account_firstname']);
														$account_lastname  = ucwords($row_teacher['account_lastname']);

														print "<td>$account_firstname $account_lastname</td>";

												}else if($remarks == "Credited"){
													print "<td >--</td>";

												}else{
														print "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
												}

												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												$rounded_ave = round($prelim,0,PHP_ROUND_HALF_EVEN);

														if($remarks == "Credited"){
															print "<td >--</td>";
															print "<td ><span class='badge badge-success'>Credited</span></td>";

														}else if($prelim == 0){
															print "<td >--</td>";
															print "<td ><span class='badge badge-secondary'>--</span></td>";

														}else if($rounded_ave >= 75){
															print "<td >$prelim</td>";
															print "<td ><span class='badge badge-primary'>Passed</span></td>";

														}else if($rounded_ave < 75){
															print "<td >$prelim</td>";
															print "<td ><span class='badge badge-danger'>Failed</span></td>";
														}
												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												print "</tr>";
											}

									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//MIDTERM
									}else if($period == "Midterm"){

										$query4 = mysqli_query($con, "SELECT * FROM grades_report 
											JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id 
											WHERE grades_report.enrollment_id = '$enrollment_id'");

								

											while($row4 = mysqli_fetch_array($query4)){
												
												//manage_subject table
												$subject_id           = $row4['subject_id'];
												$subject_code         = $row4['subject_code'];
												$subject_description  = $row4['subject_description'];
												$subject_unit         = $row4['subject_unit'];

												//grades_report table
												$grades_report_id = $row4['grades_report_id'];
												$midterm          = $row4['midterm'];
												$grades_section   = $row4['grades_section'];
												$remarks          = $row4['remarks'];

												print "<tr style = 'text-align:center;'>";

												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------
												
												print "
														<td class = 'table_data'>$subject_code</td>
														<td class = 'table_data'>$subject_description</td>
														<td class = 'table_data'>$subject_unit</td>";
												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												// checks if there is a teacher aasigned to this subject and section
												$query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
												JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
												WHERE teacher_subject_load.subject_id = '$subject_id'
												AND teacher_subject_load.subject_section = '$grades_section'
												AND teacher_subject_load.academic_id = '$academic_id'");

												if(mysqli_num_rows($query_teacher_schedule)>0){
													$row_teacher = mysqli_fetch_array($query_teacher_schedule);

														//teacher name
														$account_firstname  = ucwords($row_teacher['account_firstname']);
														$account_lastname  = ucwords($row_teacher['account_lastname']);

														print "<td>$account_firstname $account_lastname</td>";

												}else if($remarks == "Credited"){
													print "<td >--</td>";

												}else{
														print "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
												}

												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												$rounded_ave = round($midterm,0,PHP_ROUND_HALF_EVEN);

														if($remarks == "Credited"){
															print "<td >--</td>";
															print "<td ><span class='badge badge-success'>Credited</span></td>";

														}else if($midterm == 0){
															print "<td >--</td>";
															print "<td ><span class='badge badge-secondary'>--</span></td>";

														}else if($rounded_ave >= 75){
															print "<td >$midterm</td>";
															print "<td ><span class='badge badge-primary'>Passed</span></td>";

														}else if($rounded_ave < 75){
															print "<td >$midterm</td>";
															print "<td ><span class='badge badge-danger'>Failed</span></td>";
														}
												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												print "</tr>";
											}

									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//FINAL
									}else if($period == "Final"){

										$query4 = mysqli_query($con, "SELECT * FROM grades_report 
											JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id 
											WHERE grades_report.enrollment_id = '$enrollment_id'");

								

											while($row4 = mysqli_fetch_array($query4)){
												
												//manage_subject table
												$subject_id           = $row4['subject_id'];
												$subject_code         = $row4['subject_code'];
												$subject_description  = $row4['subject_description'];
												$subject_unit         = $row4['subject_unit'];

												//grades_report table
												$grades_report_id = $row4['grades_report_id'];
												$final            = $row4['final'];
												$grades_section   = $row4['grades_section'];
												$remarks          = $row4['remarks'];


												print "<tr style = 'text-align:center;'>";

												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------
												
												print "
														<td class = 'table_data'>$subject_code</td>
														<td class = 'table_data'>$subject_description</td>
														<td class = 'table_data'>$subject_unit</td>";
												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												// checks if there is a teacher aasigned to this subject and section
												$query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
												JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
												WHERE teacher_subject_load.subject_id = '$subject_id'
												AND teacher_subject_load.subject_section = '$grades_section'
												AND teacher_subject_load.academic_id = '$academic_id'");

												if(mysqli_num_rows($query_teacher_schedule)>0){
													$row_teacher = mysqli_fetch_array($query_teacher_schedule);

														//teacher name
														$account_firstname  = ucwords($row_teacher['account_firstname']);
														$account_lastname  = ucwords($row_teacher['account_lastname']);

														print "<td>$account_firstname $account_lastname</td>";

												}else if($remarks == "Credited"){
													print "<td >--</td>";

												}else{
														print "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
												}

												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												$rounded_ave = round($final,0,PHP_ROUND_HALF_EVEN);

														if($remarks == "Credited"){
															print "<td >--</td>";
															print "<td ><span class='badge badge-success'>Credited</span></td>";

														}else if($final == 0){
															print "<td >--</td>";
															print "<td ><span class='badge badge-secondary'>--</span></td>";

														}else if($rounded_ave >= 75){
															print "<td >$final</td>";
															print "<td ><span class='badge badge-primary'>Passed</span></td>";

														}else if($rounded_ave < 75){
															print "<td >$final</td>";
															print "<td ><span class='badge badge-danger'>Failed</span></td>";
														}
												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												print "</tr>";
											}

									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//AVERAGE
									}else if($period == "Average"){

										$query4 = mysqli_query($con, "SELECT * FROM grades_report 
											JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id 
											WHERE grades_report.enrollment_id = '$enrollment_id'");

								

											while($row4 = mysqli_fetch_array($query4)){
												
												//manage_subject table
												$subject_id           = $row4['subject_id'];
												$subject_code         = $row4['subject_code'];
												$subject_description  = $row4['subject_description'];
												$subject_unit         = $row4['subject_unit'];

												//grades_report table
												$grades_report_id = $row4['grades_report_id'];
												$average          = $row4['average'];
												$grades_section   = $row4['grades_section'];
												$remarks          = $row4['remarks'];


												print "<tr style = 'text-align:center;'>";

												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------
												
												print "
														<td class = 'table_data'>$subject_code</td>
														<td class = 'table_data'>$subject_description</td>
														<td class = 'table_data'>$subject_unit</td>";
												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												// checks if there is a teacher aasigned to this subject and section
												$query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
												JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
												WHERE teacher_subject_load.subject_id = '$subject_id'
												AND teacher_subject_load.subject_section = '$grades_section'
												AND teacher_subject_load.academic_id = '$academic_id'");

												if(mysqli_num_rows($query_teacher_schedule)>0){
													$row_teacher = mysqli_fetch_array($query_teacher_schedule);

														//teacher name
														$account_firstname  = ucwords($row_teacher['account_firstname']);
														$account_lastname  = ucwords($row_teacher['account_lastname']);

														print "<td>$account_firstname $account_lastname</td>";

												}else if($remarks == "Credited"){
													print "<td >--</td>";

												}else{
														print "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
												}

												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												$rounded_ave = round($average,0,PHP_ROUND_HALF_EVEN);

														if($remarks == "Credited"){
															print "<td >--</td>";
															print "<td ><span class='badge badge-success'>Credited</span></td>";

														}else if($average == 0){
															print "<td >--</td>";
															print "<td ><span class='badge badge-secondary'>--</span></td>";

														}else if($rounded_ave >= 75){
															print "<td >$average</td>";
															print "<td ><span class='badge badge-primary'>Passed</span></td>";

														}else if($rounded_ave < 75){
															print "<td >$average</td>";
															print "<td ><span class='badge badge-danger'>Failed</span></td>";
														}
												//-------------------------------------------------------------------------
												//-------------------------------------------------------------------------

												print "</tr>";
											}

									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									//--------------------------------------------------------------------------------------------------------
									}


						print "</tbody> </table>";
          ?>

<br><hr style="margin-top: -1px;"><br>


<table class="mt-2" style = 'margin-left: 20px;'>
  <tr>
    <td style="width: 50%;"><br><span style = 'text-decoration:overline'>Signature Over Printed Name </span></td>
    <td style="width: 15%;"><u><?php echo $faculty_fullname ; ?></u><br> <?php echo $faculty_position; ?> </td>
  </tr>
</table>




</body>
</html>