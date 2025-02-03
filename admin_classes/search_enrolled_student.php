<?php

  include 'config_mysqli.php';

  //EMPTY SEARCH BOX
  if(empty($_POST['search_student'])){

    $response = '
      <table class="table table-striped" style = "margin-bottom:100px;">
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

    $query1 = mysqli_query($con, "SELECT * FROM manage_enrollment
                                          JOIN academic_year ON manage_enrollment.academic_id = academic_year.academic_id
                                          JOIN manage_program ON manage_enrollment.program_id = manage_program.program_id
                                          WHERE academic_year.academic_status = 1
                                          ORDER BY manage_enrollment.student_section ASC,
                                                  manage_enrollment.student_lastname ASC, 
                                                  manage_enrollment.student_year_level ASC LIMIT 50");

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


//<!---------------------------------------------------------------------------------------------------------------------------------->
//<!---------------------------------------------------------------------------------------------------------------------------------->

  //SEARCH BOX NOT EMPTY
  }else if(isset($_POST['search_student'])){

    $search_student = $_POST['search_student'];

    $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
    while($row_academic = mysqli_fetch_array($query_academic)){
      $academic_id    = $row_academic['academic_id'];
    
    

      $query = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE academic_id = '$academic_id' AND
                                                ((student_id LIKE '%".$search_student."%')
                                                OR (student_firstname LIKE '%".$search_student."%')
                                                OR (student_lastname LIKE '%".$search_student."%')
                                                OR (student_middlename LIKE '%".$search_student."%')
                                                OR (student_name_extension LIKE '%".$search_student."%'))
                                                ORDER BY student_section ASC,
                                                student_lastname ASC, 
                                                student_year_level ASC LIMIT 50");

        if(mysqli_num_rows($query)>0){   
          $response = '
            <table class="table table-striped" style = "margin-bottom:100px;">
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

          while($row = mysqli_fetch_array($query)){
            $enrollment_id         = $row['enrollment_id'];
            $student_id            = $row['student_id'];
            $student_lastname      = ucwords($row['student_lastname']);
            $student_firstname     = ucwords($row['student_firstname']);
            $student_middlename    = ucwords($row['student_middlename']);
            $program_id            = $row['program_id'];
            $student_section       = $row['student_section'];
            $student_year_level    = $row['student_year_level'];
            $student_status        = $row['student_status'];
            $student_type          = $row['student_type'];

            $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
            while($row_program = mysqli_fetch_array($query_program)){
              $program_code = $row_program['program_code'];
            }

            $response .= "
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
                </tr>
            ";
          }
          $response .= "</tbody></table>";
          echo $response;

      
      }else{
        echo "<h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
      }

    }

  }
?>