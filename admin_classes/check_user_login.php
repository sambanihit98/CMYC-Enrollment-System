<?php

session_start();

  include 'config_mysqli.php';

//<!---------------------------------------------------------------------------------------------------------------------------->
//<!---------------------------------------------------------------------------------------------------------------------------->

  if($_POST['account_position'] == 'System Admin'){

    $account_position     = $_POST['account_position'];
    $system_admin_user_id = $_POST['account_user_id'];
    $account_password     = $_POST['account_password'];

      $query_deactivated = mysqli_query($con, "SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$system_admin_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'System Admin'
                                  AND account_status = 0");

      $query1 = mysqli_query($con,"SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$system_admin_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'System Admin'
                                  AND account_status = 1");

      $query2 = mysqli_query($con,"SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$system_admin_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'System Admin'
                                  AND account_status = 2");

        //deactivated
        if(mysqli_num_rows($query_deactivated)>0){                       
          echo json_encode(array("statusCode"=>204));

        //archived
        }else if(mysqli_num_rows($query2)>0){                       
          echo json_encode(array("statusCode"=>205));
          
        //login
        }else if(mysqli_num_rows($query1)>0){

          $_SESSION['system_admin_user_id'] = $system_admin_user_id;
          echo json_encode(array("statusCode"=>201));

        //user or password is incorrect
        }else{
            echo json_encode(array("statusCode"=>200));
        }

//<!---------------------------------------------------------------------------------------------------------------------------->
//<!---------------------------------------------------------------------------------------------------------------------------->

  }else if($_POST['account_position'] == 'Teacher'){

    $account_position = $_POST['account_position'];
    $teacher_user_id  = $_POST['account_user_id'];
    $account_password = $_POST['account_password'];

    $query_deactivated = mysqli_query($con, "SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$teacher_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'Teacher'
                                  AND account_status = 0");

    $query1 = mysqli_query($con,"SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$teacher_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'Teacher'
                                  AND account_status = 1");

    $query2 = mysqli_query($con,"SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$teacher_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'Teacher'
                                  AND account_status = 2");

    //deactivated
    if(mysqli_num_rows($query_deactivated)>0){                       
      echo json_encode(array("statusCode"=>204));

    //archived
    }else if(mysqli_num_rows($query2)>0){                       
      echo json_encode(array("statusCode"=>205));

    //login
    }else if(mysqli_num_rows($query1)>0){

      $_SESSION['teacher_user_id'] = $teacher_user_id;
      echo json_encode(array("statusCode"=>202));

    //user or password is incorrect
    }else{
      echo json_encode(array("statusCode"=>200));
    }
    
//<!---------------------------------------------------------------------------------------------------------------------------->
//<!---------------------------------------------------------------------------------------------------------------------------->


  }else if($_POST['account_position'] == 'Registrar'){

    $account_position  = $_POST['account_position'];
    $registrar_user_id = $_POST['account_user_id'];
    $account_password  = $_POST['account_password'];

    $query_deactivated = mysqli_query($con, "SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$registrar_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'Registrar'
                                  AND account_status = 0");

    $query1 = mysqli_query($con,"SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$registrar_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'Registrar'
                                  AND account_status = 1");

    $query2 = mysqli_query($con,"SELECT * FROM faculty_account 
                                  WHERE account_user_id = '$registrar_user_id'
                                  AND account_password = '$account_password'
                                  AND account_position = 'Registrar'
                                  AND account_status = 2");

    //deactivated
    if(mysqli_num_rows($query_deactivated)>0){                       
      echo json_encode(array("statusCode"=>204));

    //archived
    }else if(mysqli_num_rows($query2)>0){                       
      echo json_encode(array("statusCode"=>205));

    //login
    }else if(mysqli_num_rows($query1)>0){
  
      $_SESSION['registrar_user_id'] = $registrar_user_id;
      echo json_encode(array("statusCode"=>203));  
    
    //user or password is incorrect
    }else{
      echo json_encode(array("statusCode"=>200));
    }

  }


?>