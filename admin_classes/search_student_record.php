<?php

include 'config_mysqli.php';

  if(empty($_POST['search_student'])){

    $response = "
      <table class='mt-2 table table-striped' style = 'margin-bottom:100px;'>
      <thead class='bg-success text-center'>
        <th > STUDENT ID </th>
        <th > LAST NAME </th>
        <th > FIRST NAME </th>
        <th > MIDDLE NAME</th>
        <th > COURSE </th>
        <th > STATUS </th>
        <th > ACTION </th>
      </thead>
    ";

    $response .= "<tbody class='text-center';>";

    $query = mysqli_query($con, "SELECT * FROM student_info ORDER BY lastname LIMIT 50");

    while($row = mysqli_fetch_array($query)){
      $student_id   = $row['student_id'];
      $firstname    = ucwords($row['firstname']);
      $middlename   = ucwords($row['middlename']);
      $lastname     = ucwords($row['lastname']);

      $curriculum_id = $row['curriculum_id'];

      $query_program = mysqli_query($con, "SELECT * FROM manage_curriculum JOIN manage_program 
        ON manage_curriculum.program_id = manage_program.program_id
        WHERE manage_curriculum.curriculum_id = '$curriculum_id'");

        while($row_program = mysqli_fetch_array($query_program)){
          $program_code        = $row_program['program_code'];
          $program_description = $row_program['program_description'];

          $response .= "
            <tr>
              <td>$student_id</td>
              <td>$lastname</td>
              <td>$firstname</td>
              <td>$middlename</td>
              <td title = '$program_description'>$program_code</td>";

                $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                while($row_academic = mysqli_fetch_array($query_academic)){
                  $academic_id = $row_academic['academic_id'];
                
                  $query_enroll = mysqli_query($con,"SELECT * FROM manage_enrollment WHERE academic_id = '$academic_id' AND student_id = '$student_id'");
                  
                  if(mysqli_num_rows($query_enroll)>0){

                    $response .= "
                      <td>
                        <span class='badge badge-primary'>Enrolled</span>
                      </td>";

                  }else{

                    $response .= "
                      <td>
                        <span class='badge badge-secondary'>Not enrolled</span>
                      </td>";

                  }//end of if else

                }//end of while
                      
            
          $response .= "
              <td>
                <div class='dropdown dropleft'>
                  <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                      Action 
                  </button>

                  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                    <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#student_info' id = 'view_info'><i class='fa fa-eye fa-fw'></i>View Info</a>
                    <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>Update</a>
                    <a class='dropdown-item' href='registrar_student_grades_report.php?student_id=$student_id' id = 'grades_report'><i class='fa fa-list-ul'></i> Grades Report</a>
                    <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_password'><i class='fa fa-refresh fa-fw'></i>Reset Password</a>
                  </div> 
                </div>  
              </td>
            </tr>";

      }
    }

    $response .= "</tbody></table>";

    echo $response;

//<!---------------------------------------------------------------------------------------------------------------------------------->
//<!---------------------------------------------------------------------------------------------------------------------------------->

}else if(isset($_POST['search_student'])){
  $search_student = $_POST['search_student'];

  $query = mysqli_query($con, "SELECT * FROM student_info WHERE (student_id LIKE '%".$search_student."%')
                                                OR (firstname LIKE '%".$search_student."%')
                                                OR (lastname LIKE '%".$search_student."%')
                                                OR (middlename LIKE '%".$search_student."%')
                                                OR (name_extension LIKE '%".$search_student."%')
                                                ORDER BY lastname LIMIT 50");
  if(mysqli_num_rows($query)>0){  

    $response = "
      <table class='mt-2 table table-striped' style = 'margin-bottom:100px;'>
      <thead class='bg-success text-center'>
        <th > STUDENT ID </th>
        <th > LAST NAME </th>
        <th > FIRST NAME </th>
        <th > MIDDLE NAME </th>
        <th > COURSE </th>
        <th > STATUS </th>
        <th > ACTION </th>
      </thead>
    ";

    $response .= "<tbody class='text-center';>";
  
      while($row = mysqli_fetch_array($query)){
        $student_id   = $row['student_id'];
        $firstname    = ucwords($row['firstname']);
        $middlename   = ucwords($row['middlename']);
        $lastname     = ucwords($row['lastname']);

        $curriculum_id = $row['curriculum_id'];

        //Get the program/course code
        $query_program = mysqli_query($con, "SELECT * FROM manage_curriculum JOIN manage_program 
          ON manage_curriculum.program_id = manage_program.program_id
          WHERE manage_curriculum.curriculum_id = '$curriculum_id'");

          while($row_program = mysqli_fetch_array($query_program)){
            $program_code        = $row_program['program_code'];
            $program_description = $row_program['program_description'];

              $response .= "
                <tr>
                  <td>$student_id</td>
                  <td>$lastname</td>
                  <td>$firstname</td>
                  <td>$middlename</td>
                  <td title = '$program_description'>$program_code</td>";

                    $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                    while($row_academic = mysqli_fetch_array($query_academic)){
                      $academic_id = $row_academic['academic_id'];
                    
                      $query_enroll = mysqli_query($con,"SELECT * FROM manage_enrollment WHERE academic_id = '$academic_id' AND student_id = '$student_id'");
                      
                      if(mysqli_num_rows($query_enroll)>0){

                        $response .= "
                          <td>
                            <span class='badge badge-primary'>Enrolled</span>
                          </td>";

                      }else{

                        $response .= "
                          <td>
                            <span class='badge badge-secondary'>Not enrolled</span>
                          </td>";

                      }//end of if else
                    }//end of while
                           
              $response .= "
                  <td>
                    <div class='dropdown dropleft'>
                      <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                          Action 
                      </button>

                      <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                        <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#student_info' id = 'view_info'><i class='fa fa-eye fa-fw'></i>View Info</a>
                        <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>Update</a>
                        <a class='dropdown-item' href='registrar_student_grades_report.php?student_id=$student_id' id = 'grades_report'><i class='fa fa-list-ul'></i> Grades Report</a>
                        <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_password'><i class='fa fa-refresh fa-fw'></i>Reset Password</a>
                      </div> 
                    </div>  
                  </td>
                </tr>";
          }
      }

      $response .= "</tbody></table>";
      echo $response;

  }else{
    echo "<h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
  }

}


?>