<?php  

include 'config_mysqli.php';

    if(isset($_POST['department_id'])){
        
        $department_id = $_POST['department_id'];
        

        $query = mysqli_query($con, "SELECT * FROM `manage_program` WHERE `department_id` = '$department_id'");

        if(mysqli_num_rows($query)>0){
            
            $response = "
            
                <div class='ibox-content'>
                    <div class='table-responsive'>
                        <table class='table table-striped'>
                            <thead class='bg-success text-center'>
                            <th > Program Code </th>
                            <th > Description </th>
                            <th > Status </th>
                            <th > Action </th>
                            </thead>
                            <tbody class='text-center';> "; 
                            $query = mysqli_query($con, "SELECT * FROM manage_program WHERE department_id = '$department_id' ORDER BY program_code ASC");

                            while($row = mysqli_fetch_array($query)){

                                $program_id = $row['program_id'];
                                $program_code = $row['program_code'];
                                $program_description = $row['program_description'];
                                $program_status = $row['program_status'];
                                $department_id = $row['department_id'];
                            
                                if($program_status == 1){

            $response .= "
                                    <tr>
                                        <td > $program_code </td>
                                        <td > $program_description </td>
                                        <td style='text-align: center;'> <span class='badge badge-primary'>ACTIVE</span> </td>
                                        <td >
                                            <div class='dropdown dropleft'>
                                                <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    Action 
                                                </button>

                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                                    <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>Update</a>
                                                    <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'activate'><i class='fa fa-lock fa-fw'></i>Deactivate</a>
                                                    <a class='dropdown-item' href = '' data-id='$program_id' data-toggle='modal' data-target = '#delete_modal'> <i class='fa fa-trash fa-fw'></i>Delete</a>
                                                </div> 
                                            </div>                             
                                        </td>
                                    </tr> ";

                                }else{

            $response .= "
                                    <tr>
                                        <td > $program_code </td>
                                        <td > $program_description </td>
                                        <td style='text-align: center;'> <span class='badge badge-danger'>INACTIVE</span> </td>
                                        <td >
                                            <div class='dropdown dropleft'>
                                                <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    Action 
                                                </button>

                                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                                    <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>Update</a>
                                                    <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#activate_modal' id = 'activate'><i class='fa fa-unlock fa-fw'></i>Activate</a>
                                                    <a class='dropdown-item' href = '' data-id='$program_id' data-toggle='modal' data-target = '#delete_modal'> <i class='fa fa-trash fa-fw'></i>Delete</a>
                                                </div> 
                                            </div>                             
                                        </td>
                                    </tr>";

                                }

                            }

            $response .= "
                          </tbody>
                        </table>    
                    </div>
                </div>
            ";
            
            echo $response ;
            exit;
        }else{
            
            $response = "<BR><h3>NO PROGRAMS ADDED YET</h3>";
            echo $response;
          
        }
        
    }

?>