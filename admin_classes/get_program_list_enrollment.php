

<?php
    include 'config_mysqli.php';

    $department_id = $_POST['department_id'];

$response = "
                            <label class='text-dark' style='font-weight: bold;' >COURSE</label>";
$response .= "
                              <select class='form-control border border-secondary rounded input-sm select' name='select_program' id='select_program'>
                                <option value='' hidden>Course</option>";

                                $query = mysqli_query($con, "SELECT * FROM manage_program WHERE department_id = '$department_id' AND program_status = 1");
                                        
                                  while($row = mysqli_fetch_array($query)){
                                    $program_id = $row['program_id'];
                                    $department_id = $row['department_id'];
                                    $program_code = $row['program_code'];
                                    $program_description = $row['program_description'];
                                    $semicolon = " : ";

                                    $program = $program_code.$semicolon.$program_description;
                                        
$response .= "
                                    <option value='$program_id'>$program</option>";
                            
                                  }             

$response .= "        
                              </select>";

                echo $response;
                exit;      

?>