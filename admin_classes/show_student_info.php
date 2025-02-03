<?php
  include 'config_mysqli.php';

  $student_id = $_POST['student_id'];

  $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
    while($row = mysqli_fetch_array($query)){
      $student_id    = $row['student_id'];
      $firstname     = $row['firstname'];
      $middlename    = $row['middlename'];
      $lastname      = $row['lastname'];
      $name_extension= $row['name_extension'];
      $address       = $row['address'];
      $birthdate     = $row['birthdate'];
      $birthplace    = $row['birthplace'];
      $gender        = $row['gender'];
      $civil_status  = $row['civil_status'];
      $citizenship   = $row['citizenship'];
      $religion      = $row['religion'];
      $phone_number  = $row['phone_number'];
      $email         = $row['email'];

      $response = "
      <h2 style = 'text-align:center;'> Student Information </h2><hr>
        <table class = 'table table-striped' >
          <tbody >
            <tr >
              <th >Student ID:</th>
              <td>$student_id</td>
            </tr>
            <tr>
              <th>Firstname:</th>
              <td>$firstname</td>
            </tr>
            <tr>
              <th>Middlename:</th>
              <td>$middlename</td>
            </tr>
            <tr>
              <th>Lastname:</th>
              <td>$lastname $name_extension</td>
            </tr>
            <tr>
              <th>Address:</th>
              <td>$address</td>
            </tr>
            <tr>
              <th>Birthdate:</th>
              <td>$birthdate</td>
            </tr>
            <tr>
              <th>Birthplace:</th>
              <td>$birthplace</td>
            </tr>
            <tr>
              <th>Gender:</th>
              <td>$gender</td>
            </tr>
            <tr>
              <th>Civil Status:</th>
              <td>$civil_status</td>
            </tr>
            <tr>
              <th>Citizenship:</th>
              <td>$citizenship</td>
            </tr>
            <tr>
              <th>Religion:</th>
              <td>$religion</td>
            </tr>
            <tr>
              <th>Phone Number:</th>
              <td>$phone_number</td>
            </tr>
            <tr>
              <th>Email:</th>
              <td>$email</td>
            </tr>
          </tbody>
        </table>
        ";

        echo $response;
        exit;
    }
?>