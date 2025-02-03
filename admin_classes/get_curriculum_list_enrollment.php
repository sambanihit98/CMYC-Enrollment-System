<?php
    include 'config_mysqli.php';

    //$department_id = $_POST['department_id'];
    $program_id = $_POST['program_id'];

$response = "
                            <label class='text-dark' style='font-weight: bold;' >CURRICULUM</label>";
$response .= "
                              <select class='form-control border border-secondary rounded input-sm select'  name = 'select_curriculum' id='select_curriculum'>
                              <option value='' hidden>Curriculum</option>";

                                $query = mysqli_query($con, "SELECT * FROM manage_curriculum 
                                                              JOIN manage_program ON manage_curriculum.program_id = manage_program.program_id
                                                              WHERE manage_curriculum.program_id = '$program_id' 
                                                              AND manage_program.program_id = '$program_id' 
                                                              AND manage_curriculum.curriculum_status = 1");
                                        
                                  while($row = mysqli_fetch_array($query)){
                                    $curriculum_id = $row['curriculum_id'];
                                    $program_code = $row['program_code'];
                                    $curriculum_year = $row['curriculum_year'];

$response .= "
                                    <option value='$curriculum_id'>$program_code - $curriculum_year</option>";
                            
                                  }             

$response .= "        
                              </select>";

                echo $response;
                exit;      

?>