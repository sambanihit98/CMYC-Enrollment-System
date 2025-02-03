<?php
  include 'config_mysqli.php';

    $student_id = $_POST['student_id'];

    $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
    while($row = mysqli_fetch_array($query)){
      $firstname        = $row['firstname'];
      $middlename       = $row['middlename'];
      $lastname         = $row['lastname'];
      $name_extension   = $row['name_extension'];
      $address          = $row['address'];
      $birthdate        = $row['birthdate'];
      $birthplace       = $row['birthplace'];
      $gender           = $row['gender'];
      $civil_status     = $row['civil_status'];
      $citizenship      = $row['citizenship'];
      $religion         = $row['religion'];
      $phone_number     = $row['phone_number'];
      $email            = $row['email'];

      //updates name on table: student_info || manage_enrollment

      $response = "
        <div class='row mt-4' >
          <div class='col-md' >
            <label  class='text-dark' style='font-weight: bold' >STUDENT ID</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='student_id' value = '$student_id' disabled>
          </div>

          <div class='col-md' >
            <label  class='text-dark' style='font-weight: bold' >LASTNAME</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_lastname' value = '$lastname' >
          </div>

          <div class='col-md' >
              <label  class='text-dark' style='font-weight: bold;' >FIRSTNAME</label>
              <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_firstname' value = '$firstname' >        
          </div> 

          <div class='col-md' >
              <label  class='text-dark' style='font-weight: bold;' >MIDDLENAME</label>
              <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_middlename' value = '$middlename' >        
          </div> 

          <div class='col-md' >
              <label  class='text-dark' style='font-weight: bold;' >NAME EXTENTION</label>
              <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_name_extension' value = '$name_extension' >        
          </div>         
        </div> 


        <div class='row mt-4'>
          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >HOME ADDRESS</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_address' value = '$address' >
          </div>
        </div>


        <div class='row mt-4'>
          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >DATE OF BIRTH</label>
            <input type='date' class='form-control border border-secondary rounded input-sm' name='' id='new_birthdate' value = '$birthdate' >
          </div> 

          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >PLACE OF BIRTH</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_birthplace' value = '$birthplace' >
          </div> 

          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >GENDER</label>
              <select class='form-control border border-secondary rounded input-sm' name='' id='new_gender'>
                <option value='$gender' hidden>$gender</option>
                <option value='Male'>Male</option>
                <option value='Female'>Female</option>
              </select>
          </div>

          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >CIVIL STATUS</label>
              <select class='form-control border border-secondary rounded input-sm' name='' id='new_civil_status'>
                <option value='$civil_status' hidden>$civil_status</option>
                <option value='Married'>Married</option>
                <option value='Single'>Single</option>
              </select>
          </div>
        </div>

        <div class='row mt-4'>
          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >CITIZENSHIP</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_citizenship' value = '$citizenship' >
          </div> 

          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >RELIGION</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_religion' value = '$religion' >
          </div>

          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >MOBILE PHONE</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_phone_number' value = '$phone_number' >
          </div>

          <div class='col-sm'>
            <label class='text-dark' style='font-weight: bold;' >EMAIL ADDRESS</label>
            <input type='text' class='form-control border border-secondary rounded input-sm' name='' id='new_email' value = '$email' >
          </div>  
        </div>
      ";

      echo $response;
      exit;
    }
?>