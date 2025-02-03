<?php
  include 'config_mysqli.php';

    $enrollment_id = $_POST['enrollment_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
    while($row = mysqli_fetch_array($query)){
      $student_id               = $row['student_id'];
      $student_firstname        = $row['student_firstname'];
      $student_middlename       = $row['student_middlename'];
      $student_lastname         = $row['student_lastname'];
      $student_name_extension   = $row['student_name_extension'];
      
      //foreign keys
      $curriculum_id            = $row['curriculum_id'];
      $program_id               = $row['program_id'];
      $department_id            = $row['department_id'];

      $student_year_level       = $row['student_year_level'];
      $student_section          = $row['student_section'];
      $student_status           = $row['student_status'];
      $student_type             = $row['student_type'];

      if($student_year_level == 1){
          $year_level = "1st Year";
      }else if($student_year_level == 2){
          $year_level = "2nd Year";
      }else if($student_year_level == 3){
          $year_level = "3rd Year";
      }else if($student_year_level == 4){
          $year_level = "4th Year";
      }


      //updates name on table: student_info || manage_enrollment

      $response = "
        <div class='row mt-4' >
          <div class='col-md' >
            <label  class='text-dark' style='font-weight: bold' >STUDENT ID</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='student_id' value = '$student_id' disabled>
          </div>

          <div class='col-md' >
            <label  class='text-dark' style='font-weight: bold' >LASTNAME</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_lastname' value = '$student_lastname' >
          </div>
        </div>

        <div class='row mt-4' >
          <div class='col-md' >
              <label  class='text-dark' style='font-weight: bold;' >FIRSTNAME</label>
              <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_firstname' value = '$student_firstname' >        
          </div> 

          <div class='col-md' >
              <label  class='text-dark' style='font-weight: bold;' >MIDDLENAME</label>
              <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_middlename' value = '$student_middlename' >        
          </div> 

          <div class='col-md' >
              <label  class='text-dark' style='font-weight: bold;' >NAME EXTENTION</label>
              <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_name_extension' value = '$student_name_extension' >        
          </div>         
        </div> 

        <br><hr>

        <div class='row'>
          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >STATUS</label>
              <select class='form-control border border-secondary rounded input-sm' name='' id='new_student_status'>
                <option value='$student_status' hidden>$student_status</option>
                <option value='Regular'>Regular</option>
                <option value='Irregular'>Irregular</option>
              </select>
          </div>

          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;'>YEAR LEVEL</label>
              <select class='form-control border border-secondary rounded input-sm' name='' id='new_student_year_level'>
                <option value='$student_year_level' hidden>$year_level</option>
                <option value='1'>1st Year</option>
                <option value='2'>2nd Year</option>
                <option value='3'>3rd Year</option>
                <option value='4'>4th Year</option>
              </select>
          </div>
        </div>

        <div class='row mt-4'>
          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;'>SECTION</label>
              <select class='form-control border border-secondary rounded input-sm' name='' id='new_student_section'>
                <option value='$student_section' hidden>$student_section</option>
                <option value='A'>A</option>
                <option value='B'>B</option>
                <option value='C'>C</option>
                <option value='D'>D</option>
                <option value='E'>E</option>
              </select>
          </div>

          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;'>TYPE</label>
              <select class='form-control border border-secondary rounded input-sm' name='' id='new_student_type'>
                <option value='$student_type' hidden>$student_type</option>
                <option value='New Student'  > New Student </option>
                <option value='Old Student'  > Old Student </option>
                <option value='Returnee'     > Returnee </option>
                <option value='Transferee'   > Transferee </option>
                <option value='Shiftee'      > Shiftee </option>
              </select>
          </div>

        </div>

      ";

      //hidden
      $response .= "<input type='text' name='' id='enrollment_id' value = '$enrollment_id' hidden>";

      echo $response;
      exit;
    }
?>