<?php

    include 'config_mysqli.php';

    $select_year_level = $_POST['select_year_level'];
    $select_semester = $_POST['select_semester'];
    $department_id = $_POST['department_id'];
    $curriculum_id = $_POST['curriculum_id'];
    
    $query = mysqli_query($con, "SELECT * FROM manage_subject 
                                    WHERE subject_year_level = '$select_year_level' 
                                    AND subject_semester = '$select_semester'
                                    AND department_id = '$department_id'
                                    AND curriculum_id = '$curriculum_id'");

    if(mysqli_num_rows($query)>0){

        $response = "
        
            <table class = 'table table-striped'>
                <thead class='bg-success text-center'>
                    
                    <th > Subject Code </th>
                    <th > Description </th>
                    <th > Units </th>
                    <th > Pre-requisite </th>
                    <th > Year Level </th>
                    <th > Semester </th>
                    <th > Status </th>
                    <th > Action </th>
            </thead>
        
        ";

            $result = mysqli_query($con, "SELECT * FROM manage_subject 
                                            WHERE subject_year_level = '$select_year_level' 
                                            AND subject_semester = '$select_semester'
                                            AND department_id = '$department_id'
                                            AND curriculum_id = '$curriculum_id'
                                            ORDER BY subject_code ASC");

                while($row = mysqli_fetch_array($result)){
                    $subject_id              = $row['subject_id'];
                    $subject_code            = $row['subject_code'];
                    $subject_description     = $row['subject_description'];
                    $subject_unit            = $row['subject_unit'];
                    $subject_id_prerequisite = $row['subject_id_prerequisite'];
                    $subject_year_level      = $row['subject_year_level'];
                    $subject_semester        = $row['subject_semester'];
                    $subject_status          = $row['subject_status'];


                    $response .= "
                    
                        <tr style = 'text-align:center;'>
                            <td>$subject_code</td>
                            <td>$subject_description</td>
                            <td>$subject_unit</td>
                            
                    ";


                        if($subject_id_prerequisite == "None"){
                            $response .= "<td><span class='badge badge-secondary' style = 'font-weight:bold;'>$subject_id_prerequisite</span></td>";

                        }else{
                            $query_prerequisite = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id_prerequisite'");
                            while($row_prerequisite = mysqli_fetch_array($query_prerequisite)){
                            $subject_code_prerequisite = $row_prerequisite['subject_code'];

                                $response .= "<td title = '$subject_description'>$subject_code_prerequisite</td>";
                            }
                        }

                        if($subject_year_level == 1){
                            $response .= "<td>1st Year</td>";

                        }else if($subject_year_level == 2){
                            $response .= "<td>2nd Year</td>";

                        }else if($subject_year_level == 3){
                            $response .= "<td>3rd Year</td>";

                        }else if($subject_year_level == 4){
                            $response .= "<td>4th Year</td>";
                        }

                        $response .= "<td id = 'sem'>$subject_semester</td>";

                        if($subject_status == 1){
                           $response .= "
                            <td style='text-align: center;'> <span class='badge badge-primary'>ACTIVE</span> </td>
                            <td>
                              <div class='dropdown dropleft'>
                                <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    Action 
                                </button>

                                  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                    <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>  Update</a>
                                    <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'deactivate'><i class='fa fa-unlock fa-fw'></i> Deactivate</a>
                                    <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#delete_modal'> <i class='fa fa-trash fa-fw'></i> Delete</a>
                                  </div> 
                              </div>
                            </td>";
                        }else{
                          $response .= "
                            <td style='text-align: center;'> <span class='badge badge-warning'>INACTIVE</span> </td>
                            <td>
                              <div class='dropdown dropleft'>
                                <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    Action 
                                </button>

                                  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                    <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>  Update</a>
                                    <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#activate_modal' id = 'deactivate'><i class='fa fa-unlock fa-fw'></i> Activate</a>
                                    <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#delete_modal'> <i class='fa fa-trash fa-fw'></i> Delete</a>
                                  </div> 
                              </div>
                            </td>";
                        }

                         
                      print "</tr>";

                }

        $response .= "</table>";

        echo $response;
        exit;
        
    }else{
        echo "<br><div style = 'text-align:center;'><h2 style = 'font-weight:bold;'>NO RECORDS FOUND</h2></div>";
    }
?>