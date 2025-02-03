<?php

include 'config_mysqli.php';

  if(empty($_POST['search_teacher'])){

    $response = "
      <table class='mt-2 table table-striped'>
      <thead class='bg-success text-center'>
        <th > ID NUMBER </th>
        <th > FULLNAME </th>
        <th > STATUS </th>
        <th > ACTION </th>
      </thead>
    ";

    $response .= "<tbody class='text-center';>";

    $query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_position = 'Teacher'");

    while($row = mysqli_fetch_array($query)){
      $account_user_id    = $row['account_user_id'];
      $account_firstname  = $row['account_firstname'];
      $account_lastname   = $row['account_lastname'];
      $account_position   = $row['account_position'];
      $account_status     = $row['account_status'];

      if ($account_status == 0) {
        $acc_STATUS = "<h5><small class='badge badge-danger'>DEACTIVATED</small></h5>";  
      }else{
        $acc_STATUS = "<h5><small class='badge badge-primary'>EMPLOYED</small></h5>"; 
      }

        $response .= "
          <tr>
            <td>$account_user_id</td>
            <td>$account_firstname $account_lastname</td>
            <td>$acc_STATUS </td>";        
          
        $response .= "
            <td>
              <div class='dropdown dropleft'>
                <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Action 
                </button>

                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                  <a  class='dropdown-item' href='registrar_teacher_scheduler_load.php?account_user_id=$account_user_id' ><i class='fa fa-pencil fa-fw'></i> Load Subject </a>
                </div> 
              </div>  
            </td>
          </tr>";
    }

    $response .= "</tbody></table>";

    echo $response;

//<!---------------------------------------------------------------------------------------------------------------------------------->
//<!---------------------------------------------------------------------------------------------------------------------------------->

}else if(isset($_POST['search_teacher'])){
  $search_teacher = $_POST['search_teacher'];

  $query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_position = 'Teacher' AND 
                                                (account_user_id LIKE '%".$search_teacher."%')
                                                OR (account_firstname LIKE '%".$search_teacher."%')
                                                OR (account_lastname LIKE '%".$search_teacher."%')
                                                ORDER BY account_firstname LIMIT 50");
  if(mysqli_num_rows($query)>0){  

    $response = "
      <table class='mt-2 table table-striped'>
      <thead class='bg-success text-center'>
        <th > ID NUMBER </th>
        <th > FULLNAME </th>
        <th > STATUS </th>
        <th > ACTION </th>
      </thead>
    ";

    $response .= "<tbody class='text-center';>";
  
      while($row = mysqli_fetch_array($query)){
        $account_user_id    = $row['account_user_id'];
        $account_firstname  = $row['account_firstname'];
        $account_lastname   = $row['account_lastname'];
        $account_position   = $row['account_position'];
        $account_status     = $row['account_status'];

          if ($account_status == 0) {
            $acc_STATUS = "<h5><small class='badge badge-danger'>DEACTIVATED</small></h5>";  
          }else{
            $acc_STATUS = "<h5><small class='badge badge-primary'>EMPLOYED</small></h5>"; 
          }
    
            $response .= "
              <tr>
                <td>$account_user_id</td>
                <td>$account_firstname $account_lastname</td>
                <td>$acc_STATUS </td>";        
              
            $response .= "
                <td>
                  <div class='dropdown dropleft'>
                    <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Action 
                    </button>
    
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                      <a  class='dropdown-item' href='registrar_teacher_scheduler_load.php?account_user_id=$account_user_id' ><i class='fa fa-pencil fa-fw'></i> Load Subject </a>
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

}


?>