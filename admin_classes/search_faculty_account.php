<?php

include 'config_mysqli.php';

//EMPTY SEARCH BOX
if(empty($_POST['search_data'])){

	$response = '
		<table class="table table-striped" style = "margin-bottom:100px;">
			<thead class="bg-success text-center">
                <th>ID NUMBER</th>
                <th>FIRSTNAME</th>
                <th>LASTNAME</th>
                <th>ACCOUNT TYPE</th>
                <th>STATUS</th>
                <th>ACTION</th>
			</thead>';

	$response .= "<tbody class='text-center'>";

	$query = mysqli_query($con, "SELECT * FROM faculty_account ORDER BY account_firstname ASC, account_lastname ASC");
		while($row = mysqli_fetch_array($query)){
			$account_user_id   = $row['account_user_id'];
			$account_firstname = $row['account_firstname'];
			$account_lastname  = $row['account_lastname'];
			$account_position  = $row['account_position'];
			$account_status    = $row['account_status'];

			if ($account_status == 1){

				$response .= "

                <tr style = 'text-align:center;'>
      
                <td> $account_user_id </td>
                <td> $account_firstname </td>
                <td> $account_lastname </td>
                <td> $account_position </td>
                <td style='text-align: center;'> <span class='badge badge-primary'>EMPLOYED</span> </td>

                <td>
                  <div class='dropdown dropleft'>
                    <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Action 
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                      
                      <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'deactivate'><i class='fa fa-lock fa-fw'></i>  Deactivate</a>
                      <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_pass'><i class='fa fa-refresh fa-fw'></i>  Reset Password</a>
                      <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive'><i class='fa fa-archive fa-fw'></i>  Archive</a>
                    </div> 
                  </div>
                </td>
              </tr>";

			}else if($account_status == 0){

				$response .= "
					<tr style = 'text-align:center;'>
					
						<td> $account_user_id </td>
						<td> $account_firstname </td>
						<td> $account_lastname </td>
						<td> $account_position </td>
						<td style='text-align: center;'> <span class='badge badge-danger'>DEACTIVATED</span> </td>

						<td>
							<div class='dropdown dropleft'>
								<button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
										Action 
								</button>
								<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
									
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#activate_modal' id = 'activate'><i class='fa fa-unlock fa-fw'></i>  Activate</a>
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_pass'><i class='fa fa-refresh fa-fw'></i>  Reset Password</a>
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive'><i class='fa fa-archive fa-fw'></i>  Archive</a>
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

//SEARCH BOX NOT EMPTY
}else if(isset($_POST['search_data'])){

	$search_data = $_POST['search_data'];

	$query = mysqli_query($con, "SELECT * FROM faculty_account WHERE
		(account_user_id LIKE '%".$search_data."%' OR
		account_firstname LIKE '%".$search_data."%' OR
		account_lastname LIKE '%".$search_data."%' OR
		account_position LIKE '%".$search_data."%') AND
		(account_status != 2)
		ORDER BY account_firstname ASC, account_lastname ASC");
   
	if(mysqli_num_rows($query)>0){  

		$response = '
		<table class="table table-striped" style = "margin-bottom:100px;">
			<thead class="bg-success text-center">
				<th>ID NUMBER</th>
				<th>FIRSTNAME</th>
				<th>LASTNAME</th>
				<th>ACCOUNT TYPE</th>
				<th>STATUS</th>
				<th>ACTION</th>
			</thead>';

		$response .= "<tbody class='text-center'>";
   
		while($row = mysqli_fetch_array($query)){
			$account_user_id   = $row['account_user_id'];
			$account_firstname = $row['account_firstname'];
			$account_lastname  = $row['account_lastname'];
			$account_position  = $row['account_position'];
			$account_status    = $row['account_status'];

			if ($account_status == 1){

				$response .= "

					<tr style = 'text-align:center;'>

						<td> $account_user_id </td>
						<td> $account_firstname </td>
						<td> $account_lastname </td>
						<td> $account_position </td>
						<td style='text-align: center;'> <span class='badge badge-primary'>EMPLOYED</span> </td>

						<td>
							<div class='dropdown dropleft'>
								<button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
										Action 
								</button>
								<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'deactivate'><i class='fa fa-lock fa-fw'></i>  Deactivate</a>
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_pass'><i class='fa fa-refresh fa-fw'></i>  Reset Password</a>
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive'><i class='fa fa-archive fa-fw'></i>  Archive</a>
								</div> 
							</div>
						</td>
					</tr>";

			}else if($account_status == 0){

				$response .= "

					<tr style = 'text-align:center;'>
					
						<td> $account_user_id </td>
						<td> $account_firstname </td>
						<td> $account_lastname </td>
						<td> $account_position </td>
						<td style='text-align: center;'> <span class='badge badge-danger'>DEACTIVATED</span> </td>

						<td>
							<div class='dropdown dropleft'>
								<button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
										Action 
								</button>
								<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
									
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#activate_modal' id = 'activate'><i class='fa fa-unlock fa-fw'></i>  Activate</a>
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_pass'><i class='fa fa-refresh fa-fw'></i>  Reset Password</a>
									<a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive'><i class='fa fa-archive fa-fw'></i>  Archive</a>
								</div> 
							</div>
						</td>
					</tr>";
			}
    }

		$response .= "</tbody></table>";

		echo $response;

    }else{
        echo "<hr><h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'><hr>";
    }
      
}

?>