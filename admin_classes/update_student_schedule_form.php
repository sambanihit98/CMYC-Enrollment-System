<?php
  include 'config_mysqli.php';

  $student_subject_load_id  = $_POST['student_subject_load_id'];
  $academic_id              = $_POST['academic_id'];
  $subject_id               = $_POST['subject_id'];

  $query = mysqli_query($con, "SELECT * FROM student_subject_load WHERE student_subject_load_id = '$student_subject_load_id'");
  while($row = mysqli_fetch_array($query)){

    //student_subject_load table
    $enrollment_id             = $row['enrollment_id'];
    $student_subject_section   = $row['student_subject_section'];


    $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
      while($row_subject = mysqli_fetch_array($query_subject)){

        //manage_subject table
        $subject_code         = $row_subject['subject_code'];
        $subject_description  = $row_subject['subject_description'];

        $response = "
          <div class='row' >
            <div class='col-md' >
              <label  class='text-dark' style='font-weight: bold' >SUBJECT CODE</label>
              <input type='text' class='form-control border border-secondary rounded input-sm'  value = '$subject_code' disabled>
            </div>
          </div>

          <div class='row mt-4' >
            <div class='col-md' >
              <label  class='text-dark' style='font-weight: bold' >SUBJECT TITLE</label>
              <input type='text' class='form-control border border-secondary rounded input-sm' value = '$subject_description' disabled>
            </div>
          </div>

          <hr>";

        $response .= "
          <div class = 'alert alert-warning alert-dismissible alert-sm'>
            <i class='fa fa-exclamation-circle'></i> <span> <i style = 'font-size:11px;'>Select from other course/section that offers the same subject</i> </span>
          </div>";

        

        //------------------------------------------------------------------------------------------------------------------------------
        //------------------------------------------------------------------------------------------------------------------------------
        //SECTION
        $response .= "
          <div class='row mt-2'>
            <div class='col-md-6'>
              <label  class='text-dark' style='font-weight: bold' >COURSE & SECTION</label>
              <select class='form-control border border-secondary rounded input-sm' id = 'choose_section'>";

              $query_distinct_subject = mysqli_query($con, "SELECT * FROM manage_subject 
                JOIN manage_program ON manage_subject.program_id = manage_program.program_id
                WHERE manage_subject.subject_code = '$subject_code' OR manage_subject.subject_description = '$subject_description'");

                while($row_distinct_subject = mysqli_fetch_array($query_distinct_subject)){
                  //manage_subject table
                  $distinct_subject_id = $row_distinct_subject['subject_id'];

                  $query_default_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                  JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
                  JOIN manage_program ON teacher_subject_load.program_id = manage_program.program_id 
                  WHERE teacher_subject_load.subject_id = '$subject_id'
                  AND teacher_subject_load.subject_section = '$student_subject_section'
                  AND teacher_subject_load.academic_id = '$academic_id'");
                  
                  
                    if(mysqli_num_rows($query_default_teacher_schedule)>0){
                      while($row_1 = mysqli_fetch_array($query_default_teacher_schedule)){
                        $default_program_id = $row_1['program_id'];
                        $default_program_code = $row_1['program_code'];
                        $default_year_level = $row_1['subject_year_level_teacher'];
                        $default_section = $row_1['subject_section'];
  
                        $response .= "<option data-program='$default_program_id' 
                                      data-year='$default_year_level'
                                      data-section='$default_section' 
                                      data-loadid='$student_subject_load_id' 
                                      data-subject='$distinct_subject_id'
                                      data-oldsubject='$subject_id'
                                      data-enrollmentid='$enrollment_id' hidden>
                                    $default_program_code - $default_year_level$default_section</option>";
                      }
                     
                    }else{
                      $response .= "<option value = '' hidden>--</option>";
                    }

                }

             
                  
                  
              $query_distinct_subject = mysqli_query($con, "SELECT * FROM manage_subject 
                JOIN manage_program ON manage_subject.program_id = manage_program.program_id
                WHERE manage_subject.subject_code = '$subject_code' OR manage_subject.subject_description = '$subject_description'");

                while($row_distinct_subject = mysqli_fetch_array($query_distinct_subject)){
                  //manage_subject table
                  $distinct_subject_id = $row_distinct_subject['subject_id'];


                  $query_distinct_teacher_schedule = mysqli_query($con, "SELECT DISTINCT subject_year_level_teacher, subject_section
                    FROM teacher_subject_load WHERE subject_id = '$distinct_subject_id' AND academic_id = '$academic_id'");
                    while($row_distinct_teacher_schedule = mysqli_fetch_array($query_distinct_teacher_schedule)){

                      //manage_program table
                      $program_id     = $row_distinct_subject['program_id'];
                      $program_code   = $row_distinct_subject['program_code'];

                      $subject_year_level_teacher = $row_distinct_teacher_schedule['subject_year_level_teacher'];
                      $subject_section            = $row_distinct_teacher_schedule['subject_section'];

                      $response .= "<option data-program='$program_id' 
                                            data-year='$subject_year_level_teacher'
                                            data-section='$subject_section'
                                            data-loadid='$student_subject_load_id'
                                            data-subject='$distinct_subject_id'
                                            data-oldsubject='$subject_id'
                                            data-enrollmentid='$enrollment_id' >$program_code - $subject_year_level_teacher$subject_section
                                    </option>";

                    }

                }

        $response .= " 
              </select>
            </div>
          </div>"; 

        //------------------------------------------------------------------------------------------------------------------------------
        //------------------------------------------------------------------------------------------------------------------------------
          

        $response .= "<div id = 'update_student_schedule_table'>";

        $response .= "
          <table class='mt-2 table table-striped'>
            <thead class='bg-success text-center'>
              <th>TIME</th>
              <th>DAY</th>
              <th>ROOM</th>
              <th>TEACHER</th>
            </thead>
          <tbody>
          ";

        $response .= "<tr class='text-center'>";

        $query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
          JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
          WHERE teacher_subject_load.subject_id = '$subject_id'
          AND teacher_subject_load.subject_section = '$student_subject_section'
          AND teacher_subject_load.academic_id = '$academic_id'");

          if(mysqli_num_rows($query_teacher_schedule)>0){
            $row_teacher = mysqli_fetch_array($query_teacher_schedule);

              //teacher name
              $account_firstname  = ucwords($row_teacher['account_firstname']);
              $account_lastname  = ucwords($row_teacher['account_lastname']);

              

              //---------------------------------------------------------------------------------------------------------------------------->
              //---------------------------------------------------------------------------------------------------------------------------->
              $response .= "<td style = 'vertical-align:middle;'>";//time
                $query_time = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                              AND subject_section = '$student_subject_section'");
                while($row_time = mysqli_fetch_array($query_time)){

                  $subject_time_from     = $row_time['subject_time_from'];
                  $subject_time_to       = $row_time['subject_time_to'];
                  $time_from             = date("g:ia", strtotime($subject_time_from));
                  $time_to               = date("g:ia", strtotime($subject_time_to));

                  $response .= "$time_from - $time_to <br><br>";
                }
              $response .="</td>";//end of time

              //---------------------------------------------------------------------------------------------------------------------------->
              //---------------------------------------------------------------------------------------------------------------------------->
              $response .= "<td style = 'vertical-align:middle;'>";//day
                $query_day = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                              AND subject_section = '$student_subject_section'");
                  while($row_day = mysqli_fetch_array($query_day)){

                    $day_initial   = $row_day['day_initial'];

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
                  
                    $response .= "$day <br><br>";
                  }
                $response .="</td>";//end of day

                //---------------------------------------------------------------------------------------------------------------------------->
                //---------------------------------------------------------------------------------------------------------------------------->
                $response .= "<td style = 'vertical-align:middle;'>";//room
                  $query_room = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                AND subject_section = '$student_subject_section'");
                    while($row_room = mysqli_fetch_array($query_room)){

                      $subject_room  = $row_room['subject_room'];

                      $response .= "$subject_room <br><br>";
                    }
                $response .="</td>";//end of room

                //---------------------------------------------------------------------------------------------------------------------------->
                //---------------------------------------------------------------------------------------------------------------------------->
                
                $response .= "<td style = 'vertical-align:middle'> $account_firstname $account_lastname <br><br></td>"; 

          }else{
            //no teacher yet
            $response .= "
                <td style = 'vertical-align:middle;'> -- </td>
                <td style = 'vertical-align:middle;'> -- </td>
                <td style = 'vertical-align:middle;'> -- </td>
                <td style = 'vertical-align:middle;'> <span class='badge badge-secondary'>No teacher yet</span> </td>";
          }  

        $response .= "</tr>";
        $response .= "</tbody></table>";

        $response .= "</div>";

        echo $response;
        exit;

      }

  }

      

      
    
?>