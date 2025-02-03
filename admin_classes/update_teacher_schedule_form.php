<?php
  include 'config_mysqli.php';

  $subject_load_id = $_POST['subject_load_id'];

  $query = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_load_id = '$subject_load_id'");
  while($row = mysqli_fetch_array($query)){

    $subject_id = $row['subject_id'];

    $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
    $row_subject = mysqli_fetch_array($query_subject);

    $subject_code        = $row_subject['subject_code'];
    $subject_description = $row_subject['subject_description'];

    $subject_year_level_teacher = $row['subject_year_level_teacher'];
    $academic_id                = $row['academic_id'];
    $subject_room               = $row['subject_room'];
    $subject_section            = $row['subject_section'];

    $subject_time_from          = $row['subject_time_from'];
    $subject_time_to            = $row['subject_time_to'];
    $day_initial                = $row['day_initial'];

    $curriculum_id              = $row['curriculum_id'];

    if($subject_year_level_teacher == 1){
      $year_level = "1st Year";
    }elseif($subject_year_level_teacher == 2){
      $year_level = "2nd Year";
    }elseif($subject_year_level_teacher == 3){
      $year_level = "3rd Year";
    }elseif($subject_year_level_teacher == 4){
      $year_level = "4th Year";
    }

    if($day_initial == "1Mon"){
      $day = "Monday";
    }else if($day_initial == "2Tue"){
      $day = "Tuesday";
    }else if($day_initial == "3Wed"){
      $day = "Wednesday";
    }else if($day_initial == "4Thu"){
      $day = "Thursday";
    }else if($day_initial == "5Fri"){
      $day = "Friday";
    }else if($day_initial == "6Sat"){
      $day = "Saturday";
    }else if($day_initial == "7Sun"){
      $day = "Sunday";
    }

    $response = "<input type='text'  id='subject_load_id' value = '$subject_load_id' hidden>";

    $response .= "
      <div class='row mt-2'>
        <div class='col-sm'>
          <label class='text-dark' style='font-weight: bold;' >SUBJECT TITLE</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' id='subject_title' value = '$subject_code: $subject_description' readonly>
        </div>
      </div><hr>";

    $response .= "
      <div class='row mt-2'>
        <div class='col-sm'>
          <label class='text-dark' style='font-weight: bold;' >DAY</label> 
            <select class='form-control border border-secondary rounded input-sm' id = 'new_subject_day'>
              <option value='$day_initial' hidden>$day</option>
              <option value='1Mon' >Monday</option>
              <option value='2Tue' >Tuesday</option>
              <option value='3Wed' >Wednesday</option>
              <option value='4Thu' >Thursday</option>
              <option value='5Fri' >Friday</option>
              <option value='6Sat' >Saturday</option>
              <option value='7Sun' >Sunday</option>
            </select>  
        </div>
      </div>";

    //<!---------------------------------------------------------------------------------------------------------------------------->
    //<!---------------------------------------------------------------------------------------------------------------------------->

    $response .= "
      <div class='row mt-4'>
        <div class='col-md-6'>
            <label class='text-dark' style='font-weight: bold;' >TIME-FROM</label>
            <input type='time' class='form-control border border-secondary rounded input-sm' id='new_subject_time_from' value = '$subject_time_from'>        
        </div> 

        <div class='col-md-6'>
            <label class='text-dark' style='font-weight: bold;' >TIME-TO</label>
            <input type='time' class='form-control border border-secondary rounded input-sm' id='new_subject_time_to' value = '$subject_time_to'>  
        </div>  
      </div>";

    //<!---------------------------------------------------------------------------------------------------------------------------->
    //<!---------------------------------------------------------------------------------------------------------------------------->

    $response .= "
      <div class='row mt-2'>   
        <div class='col-md-6'>
          <label class='text-dark' style='font-weight: bold;'>SECTION</label>

            <select class='form-control border border-secondary rounded input-sm' id='new_subject_section'>
              <option value='$subject_section' hidden>$subject_section</option>
              <option value='A'>A</option>
              <option value='B'>B</option>
              <option value='C'>C</option>
              <option value='D'>D</option>
              <option value='E'>E</option>
            </select>  
        </div> 

        <div class='col-md-6'>
          <label class='text-dark' style='font-weight: bold;' >ROOM</label>
          <input type='text' class='form-control border border-secondary rounded input-sm' id='new_subject_room' value = '$subject_room'>            
        </div>
      </div>";

    //<!---------------------------------------------------------------------------------------------------------------------------->
    //<!---------------------------------------------------------------------------------------------------------------------------->

//hidden
    $response .= "
          <input type='text' id='curriculum_id' value = '$curriculum_id' hidden>        
          <input type='text' id='subject_year_level_teacher' value = '$subject_year_level_teacher' hidden>
          <input type='text' id='subject_id' value = '$subject_id' hidden>";

    echo $response;
    exit;
  }



  
?>