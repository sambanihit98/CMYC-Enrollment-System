<?php

  include 'config_mysqli.php';

  $year_level  = $_POST['year_level'];

  $query1 = mysqli_query($con, "SELECT * FROM manage_enrollment
                                          JOIN academic_year ON manage_enrollment.academic_id = academic_year.academic_id
                                          JOIN manage_program ON manage_enrollment.program_id = manage_program.program_id
                                          WHERE academic_year.academic_status = 1 
                                          AND manage_enrollment.student_year_level = '$year_level'
                                          ORDER BY manage_enrollment.student_section ASC,
                                                  manage_enrollment.student_lastname ASC");

    if(mysqli_num_rows($query1)>0){
      $response = '
        <table class="table table-striped">
          <thead class="bg-success text-center">
            <th > Student ID </th>
            <th > Lastname </th>
            <th > Firstname </th>
            <th > Middlename</th>
            <th > Course & Section </th>
            <th > Status </th>
            <th > Type </th>
            <th > Action </th>
          </thead>';

      $response .= "<tbody class='text-center'>";

        while($row1 = mysqli_fetch_array($query1)){
          $enrollment_id         = $row1['enrollment_id'];
          $student_id            = $row1['student_id'];
          $student_lastname      = ucwords($row1['student_lastname']);
          $student_firstname     = ucwords($row1['student_firstname']);
          $student_middlename    = ucwords($row1['student_middlename']);
          $program_code          = $row1['program_code'];
          $student_section       = $row1['student_section'];
          $student_year_level    = $row1['student_year_level'];
          $student_status        = $row1['student_status'];
          $student_type          = $row1['student_type'];

            $response .=  "
              
                <tr>
                  <td> $student_id </td>
                  <td> $student_lastname </td>
                  <td> $student_firstname </td>
                  <td> $student_middlename </td>
                  <td> $program_code - $student_year_level$student_section</td>  
                  <td> $student_status </td>
                  <td> $student_type </td>
                  <td>
                    <div class='dropdown dropleft'>
                      <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Action 
                      </button>
                      <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                        <a class='dropdown-item' href='' data-id='$enrollment_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i> Update </a>
                        <a class='dropdown-item' href='' data-id='$enrollment_id' data-toggle='modal' data-target = '#delete_modal' id = 'delete'><i class='fa fa-trash fa-fw'></i> Delete </a>
                        <a class='dropdown-item' href='registrar_student_evaluation.php?enrollment_id=$enrollment_id' ><i class='fa fa-pencil-square-o fa-fw'></i> Load Subject </a>
                      </div> 
                    </div>
                  </td>
                </tr>";  
        }

        $response .= "</tbody></table>";
      
      echo $response;

    }else{
      echo "<h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
    }

  
  
?>