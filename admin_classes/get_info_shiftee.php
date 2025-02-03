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

    $response = "

      <div class='row mt-4' >
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
    </div>";

    echo $response;
    exit;
  }



  

?>