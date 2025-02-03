<?php
    include 'config_mysqli.php';

    $department_id = $_POST['department_id'];

$response = "
                <div class='row mt-2'>
                    <div class='col-sm'>
                        <label class='text-dark' style='font-weight: bold;' >CURRICULUM</label>";

$response .= "
                              <select class='form-control border border-secondary rounded input-sm select' id='subject_curriculum' name='subject_curriculum'>
                                <option value='0' hidden>Select Curriculum</option>";

                                $query = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE department_id = '$department_id' AND curriculum_status = 1");
                                        
                                    while($row = mysqli_fetch_array($query)){
                                        $curriculum_id = $row['curriculum_id'];
                                        $program_id = $row['program_id'];
                                        $department_id = $row['department_id'];
                                        $curriculum_year = $row['curriculum_year'];

                                        $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                        while($row_program = mysqli_fetch_array($query_program)){
                                          $program_code = $row_program['program_code'];
                                          $hyphen = " - ";

                                          $curriculum = $program_code.$hyphen.$curriculum_year;
                                        
$response .= "
                                    <option value='$curriculum_id'>$curriculum</option>";

                                } 
                            }             

$response .= "        
                            </select>";

$response .= "                         
                    </div>
                </div>";

                echo $response;
                exit;      

?>