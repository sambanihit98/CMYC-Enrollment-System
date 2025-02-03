<?php

  include 'config_mysqli.php';
  $subject_id = $_POST['subject_id'];

  $query = mysqli_query($con, "SELECT * FROM manage_subject 
                                JOIN manage_curriculum ON manage_subject.curriculum_id = manage_curriculum.curriculum_id
                                JOIN manage_program ON manage_curriculum.program_id = manage_program.program_id
                                WHERE manage_subject.subject_id = '$subject_id'");
  
  while($row = mysqli_fetch_array($query)){
    
      //manage_curriculum table
      $curriculum_year = $row['curriculum_year'];

      //manage_program table
      $program_code = $row['program_code'];

      $curriculum = "$program_code - $curriculum_year";
      //----------------------------------------------------
      //manage_subject table
      $subject_year_level       = $row['subject_year_level'];
      $subject_semester         = $row['subject_semester'];
      $subject_code             = $row['subject_code'];
      $subject_description      = $row['subject_description'];
      $subject_unit             = $row['subject_unit'];
      $department_id            = $row['department_id'];
      $curriculum_id            = $row['curriculum_id'];
      $subject_id_prerequisite  = $row['subject_id_prerequisite'];

      if($subject_id_prerequisite == "None"){
        $pre_requisite = "None";
      }else{
        $query_prerequisite = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id_prerequisite'");
        while($row_prerequisite = mysqli_fetch_array($query_prerequisite)){
          $prerequisite_code         = $row_prerequisite['subject_code'];
          $prerequisite_description  = $row_prerequisite['subject_description'];

          $pre_requisite = "$prerequisite_code: $prerequisite_description";
        }
      }
      


      if($subject_year_level == 1){
        $year_level = "1st Year";
      }else if($subject_year_level == 2){
        $year_level = "2nd Year";
      }else if($subject_year_level == 3){
        $year_level = "3rd Year";
      }else if($subject_year_level == 4){
        $year_level = "4th Year";
      }
  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 
  //--HIDDEN DATA
  $response = "<input type = 'text' id = 'new_subject_id'    value = '$subject_id'    hidden>";
  $response .= "<input type = 'text' id = 'new_department_id' value = '$department_id' hidden>";
  $response .= "<input type = 'text' id = 'new_curriculum_id' value = '$curriculum_id' hidden>";
  
  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 
  $response .= "
  <div class='row mt-2'>
    <div class='col-sm'>
      <label class = 'text-dark' style='font-weight: bold;'> CURRICULUM</label>
        <input type = 'text' class = 'form-control border border-secondary rounded input-sm' value = '$curriculum' readonly>
    </div>
  </div>";

  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 
  $response .= "
    <div class='row mt-2' >
      <div class='col-sm'>
        <label class='text-dark' style='font-weight: bold;' > YEAR LEVEL </label>
          <select class='form-control border-secondary rounded input-sm' id='new_subject_year_level' >
            <option value='$subject_year_level' hidden> $year_level </option>
            <option value='1' > 1st Year </option>
            <option value='2' > 2nd Year </option>
            <option value='3' > 3rd Year </option>
            <option value='4' > 4th Year </option>
          </select>
      </div>
    </div>";

  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 
  $response .= "
    <div class='row mt-2' >   
      <div class='col-sm'>
        <label class='text-dark' style='font-weight: bold;' > SEMESTER </label>
        <select class='form-control border-secondary rounded input-sm' id='new_subject_semester' >
          <option value='$subject_semester' hidden>$subject_semester</option>
          <option value='1st Semester' > 1st Semester </option>
          <option value='2nd Semester' > 2nd Semester </option>
        </select>
      </div>
    </div>
    <hr>";

  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 
  $response .= "
    <div class='row mt-2'>
      <div class='col-sm'>
        <label class='text-dark' style='font-weight: bold;'> SUBJECT CODE </label>
        <input type='text' class='form-control border border-secondary rounded input-sm' id='new_subject_code' value = '$subject_code'>
      </div>
    </div>";

  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 
  $response .= "
    <div class='row mt-2'>
      <div class='col-sm'>
        <label class='text-dark' style='font-weight: bold;'> DESCRIPTIVE TITLE </label>
        <input type='text' class='form-control border border-secondary rounded input-sm' id='new_subject_description' value = '$subject_description'>
      </div>
    </div>";

  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 
  $response .= "
    <div class='row mt-2'>
      <div class='col-sm'>
        <label class='text-dark' style='font-weight: bold;' > TOTAL UNITS </label>
        <input type='number' class='form-control border border-secondary rounded input-sm' id='new_subject_unit' value = '$subject_unit'>      
      </div>
    </div>";

  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 
  $response .= "
    <div class='row mt-2'>
      <div class='col-sm'>
        <label class='text-dark' style='font-weight: bold;' > PRE-REQUISITE </label>
          <select class='form-control border-secondary rounded input-sm' id='new_subject_id_prerequisite'>
            <option value='$subject_id_prerequisite' hidden>$pre_requisite</option>
            <option value='None' > None</option>";

              $query_pre = mysqli_query($con, "SELECT * FROM manage_subject WHERE department_id = '$department_id' AND curriculum_id = '$curriculum_id' ORDER BY subject_year_level ASC, subject_semester ASC, subject_code ASC");
                while($row_pre = mysqli_fetch_array($query_pre)){
                  $subject_id          = $row_pre['subject_id'];
                  $curriculum_id       = $row_pre['curriculum_id'];                                   
                  $subject_code        = $row_pre['subject_code'];
                  $subject_description = $row_pre['subject_description'];

                  $response .= "<option value = '$subject_id' > $subject_code - $subject_description</option>";
                }
        
  $response .= "     
          </select>   
            
      </div>
    </div>";
  //------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------ 

    echo $response;
    exit;

  }
?>