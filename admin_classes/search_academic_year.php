<?php

include 'config_mysqli.php';

//EMPTY SEARCH BOX
if(empty($_POST['search_data'])){

	$response = '
		<table class="table table-striped" style = "margin-bottom:100px;">
			<thead class="bg-success text-center">
				<th> ACADEMIC YEAR <i class="fa fa-arrow-down ml-2" id = "sort_year_asc" > </td>                      
				<th> TERM </td>
				<th> STATUS </td>
				<th> ACTION </td>
			</thead>';

	$response .= "<tbody class='text-center'>";

	$query1 = mysqli_query($con, "SELECT * FROM academic_year ORDER BY academic_year_from DESC, academic_term DESC");
		while($row = mysqli_fetch_array($query1)){
			$academic_id         = $row['academic_id'];
			$academic_year_from  = $row['academic_year_from']; 
			$academic_year_to    = $row['academic_year_to'];
			$academic_term       = $row['academic_term']; 
			$academic_status     = $row['academic_status']; 

			if($academic_status == '1'){
				$response .= "

				  <tr>
					<td style='text-align: center;'> $academic_year_from - $academic_year_to </td>
					<td style='text-align: center;'> $academic_term </td>
					<td style='text-align: center;'> <span class='badge badge-primary' >ACTIVE</span> </td>

					<td style='text-align: center;'> 
					  <div class='dropdown dropleft'>
						<button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							Action 
						</button>

						  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
							
							<a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#deactivate_modal'><i class='fa fa-lock fa-fw'></i>  Deactivate</a>
						  
						  </div> 
					  </div>
					</td>                             
				  </tr>"; 

			}else if($academic_status == '0'){

				$response .="

				  <tr>
					<td style='text-align: center;'> $academic_year_from - $academic_year_to </td>
					<td style='text-align: center;'> $academic_term </td>
					<td style='text-align: center;'> <span class='badge badge-danger'>INACTIVE</span> </td>

					<td style='text-align: center;'> 
					  <div class='dropdown dropleft'>
						<button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							Action 
						</button>

						  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
							
							<a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#activate_modal'> <i class='fa fa-unlock fa-fw'></i> Activate</a>
							<a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#archive_modal'> <i class='fa fa-archive fa-fw'></i> Archive</a>
						   
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

	$query1 = mysqli_query($con, "SELECT * FROM academic_year WHERE 
			academic_year_from LIKE '%".$search_data."%' OR 
			academic_year_to LIKE '%".$search_data."%' OR 
			academic_term LIKE '%".$search_data."%'
			ORDER BY academic_year_from DESC, academic_term DESC");
   
	if(mysqli_num_rows($query1)>0){  

		$response = '
		<table class="table table-striped" style = "margin-bottom:100px;">
			<thead class="bg-success text-center">
				<th> ACADEMIC YEAR </td>                      
				<th> TERM </td>
				<th> STATUS </td>
				<th> ACTION </td>
			</thead>';

		$response .= "<tbody class='text-center'>";
   
		while($row = mysqli_fetch_array($query1)){
			$academic_id         = $row['academic_id'];
			$academic_year_from  = $row['academic_year_from']; 
			$academic_year_to    = $row['academic_year_to'];
			$academic_term       = $row['academic_term']; 
			$academic_status     = $row['academic_status']; 

			if($academic_status == '1'){
				$response .= "

				  <tr>
					<td style='text-align: center;'> $academic_year_from - $academic_year_to </td>
					<td style='text-align: center;'> $academic_term </td>
					<td style='text-align: center;'> <span class='badge badge-primary' >ACTIVE</span> </td>

					<td style='text-align: center;'> 
					  <div class='dropdown dropleft'>
						<button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							Action 
						</button>

						  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
							
							<a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#deactivate_modal'><i class='fa fa-lock fa-fw'></i>  Deactivate</a>
						  
						  </div> 
					  </div>
					</td>                             
				  </tr>"; 

			}else if($academic_status == '0'){

				$response .="

				  <tr>
					<td style='text-align: center;'> $academic_year_from - $academic_year_to </td>
					<td style='text-align: center;'> $academic_term </td>
					<td style='text-align: center;'> <span class='badge badge-danger'>INACTIVE</span> </td>

					<td style='text-align: center;'> 
					  <div class='dropdown dropleft'>
						<button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							Action 
						</button>

						  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
							
							<a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#activate_modal'> <i class='fa fa-unlock fa-fw'></i> Activate</a>
							<a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#archive_modal'> <i class='fa fa-archive fa-fw'></i> Archive</a>
						   
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