<?php
  include 'config_mysqli.php';

  $student_id = $_POST['student_id'];

  //$query = mysqli_query($con, "SELECT * FROM student_info WHERE (student_id LIKE '%".$student_id."%')");

  $query = mysqli_query($con, "SELECT * FROM student_info 
  JOIN manage_curriculum ON student_info.curriculum_id = manage_curriculum.curriculum_id
  WHERE student_info.student_id = '$student_id'");

  $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
  while($row_academic = mysqli_fetch_array($query_academic)){
    $academic_term =$row_academic['academic_term'];
  }

if(mysqli_num_rows($query)>0){

  while($row = mysqli_fetch_array($query)){
    $firstname       = $row['firstname'];
    $middlename      = $row['middlename'];
    $lastname        = $row['lastname'];
    $name_extension  = $row['name_extension'];

		$program_id      = $row['program_id'];
    $department_id   = $row['department_id'];
    //$curriculum_id   = $row['curriculum_id'];
    //$curriculum_year = $row['curriculum_year'];

    //---------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------
    //manage_department
    $query_department = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
    $row_department   = mysqli_fetch_array($query_department);
    
    $department_code        = $row_department['department_code'];
    $department_description = $row_department['department_description'];
    $department = $department_code.': '.$department_description;

		//---------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------
    //manage_program
    $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
    $row_program   = mysqli_fetch_array($query_program);

    $program_code        = $row_program['program_code'];
    $program_description = $row_program['program_description'];
    $program = $program_code.': '.$program_description;

		//---------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------
		//manage_curriculum
		$query_curriculum = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE program_id = '$program_id' AND department_id = '$department_id' AND curriculum_status = 1");
		$row_curriculum   = mysqli_fetch_array($query_curriculum);
		
		$curriculum_id    = $row_curriculum['curriculum_id'];
		$curriculum_year  = $row_curriculum['curriculum_year'];

		//curriculum
    $curriculum = $program_code.'-'.$curriculum_year;
		//---------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------
    

    $response = " <input type='text'  value = '$department_id' name='' id='department_id'  hidden>
                  <input type='text'  value = '$program_id'    name='' id='program_id'     hidden>
                  <input type='text'  value = '$curriculum_id' name='' id='curriculum_id'  hidden>";
    
    $response .= "

      <div class='row mt-3' >
        <div class='col-md' >
          <label  class='text-dark' style='font-weight: bold' >SURNAME</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' value = '$lastname' readonly id = 'student_lastname'>
        </div>

        <div class='col-md' >
          <label  class='text-dark' style='font-weight: bold;' >GIVEN NAME</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' value = '$firstname' readonly id = 'student_firstname'>        
        </div> 

        <div class='col-md' >
          <label  class='text-dark' style='font-weight: bold;' >MIDDLENAME</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' value = '$middlename' readonly id = 'student_middlename'>        
        </div> 
  
        <div class='col-md' >
          <label  class='text-dark' style='font-weight: bold;' >NAME EXTENTION</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' value = '$name_extension' readonly id = 'student_name_extension'>        
        </div>         
      </div>

      <div class = 'row mt-4'>

        <div class='col-sm'>
          <label class='text-dark' style='font-weight: bold' >SEMESTER</label>
           <input type='text' class='form-control border border-secondary rounded input-sm' value = '$academic_term' name='' id='student_semester' readonly>    
        </div>

        <div class='col-md' >
          <label  class='text-dark' style='font-weight: bold' >DEPARTMENT</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' value = '$department' name='' id='' title = '$department' readonly>
        </div>

        <div class='col-md' >
          <label  class='text-dark' style='font-weight: bold' >COURSE</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' value = '$program' name='' id='' title = '$program' readonly>
        </div>

        <div class='col-md' >
          <label  class='text-dark' style='font-weight: bold' >CURRICULUM</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' value = '$curriculum' name='' id='' title = '$curriculum'  readonly>
        </div>

      </div>";

      echo $response;
      exit;
  }

  }else{

    $response = "

    <div class='row mt-3' >
      <div class='col-md' >
        <label  class='text-dark' style='font-weight: bold' >SURNAME</label>
        <input type='text' class='form-control border border-secondary rounded input-sm'  readonly>
      </div>

      <div class='col-md' >
        <label  class='text-dark' style='font-weight: bold;' >GIVEN NAME</label>
        <input type='text' class='form-control border border-secondary rounded input-sm' readonly>        
      </div> 

      <div class='col-md' >
        <label  class='text-dark' style='font-weight: bold;' >MIDDLENAME</label>
        <input type='text' class='form-control border border-secondary rounded input-sm'  readonly>        
      </div> 

      <div class='col-md' >
        <label  class='text-dark' style='font-weight: bold;' >NAME EXTENTION</label>
        <input type='text' class='form-control border border-secondary rounded input-sm'  readonly>        
      </div>         
    </div>

    <div class = 'row mt-4'>

      <div class='col-sm'>
        <label class='text-dark' style='font-weight: bold' >SEMESTER</label>
        <input type='text' class='form-control border border-secondary rounded input-sm' value = '$academic_term' name='' id='student_semester' readonly>    
      </div>

      <div class='col-md' >
        <label  class='text-dark' style='font-weight: bold' >DEPARTMENT</label>
        <input type='text' class='form-control border border-secondary rounded input-sm' readonly>
      </div>

      <div class='col-md' >
        <label  class='text-dark' style='font-weight: bold' >COURSE</label>
        <input type='text' class='form-control border border-secondary rounded input-sm' readonly>
      </div>

      <div class='col-md' >
        <label  class='text-dark' style='font-weight: bold' >CURRICULUM</label>
        <input type='text' class='form-control border border-secondary rounded input-sm' readonly>
      </div>

    </div>";

    echo $response;
    exit;
  }



  

?>