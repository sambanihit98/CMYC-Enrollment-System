<?php
    include 'config_mysqli.php';

    @$curriculum_id = $_POST['curriculum_id'];

    $department_id = $_POST['department_id'];
    $subject_year_level = $_POST['subject_year_level'];
    $subject_semester = $_POST['subject_semester'];



   
$response = "
                <div class='row mt-2'>
                    <div class='col-sm'>
                        <label class='text-dark' style='font-weight: bold;' >SUBJECT TITLE</label>";

$response .= "
                            <select class='form-control border border-secondary rounded input-sm' id='subject_title' name='subject_title'>
                                <option value='0' hidden>Select Subject</option>";

                                $query = mysqli_query($con, "SELECT * FROM manage_subject 
                                                                WHERE curriculum_id = '$curriculum_id'
                                                                AND subject_year_level = '$subject_year_level'
                                                                AND subject_semester = '$subject_semester'
                                                                AND department_id = '$department_id'");
                                while($row = mysqli_fetch_array($query)){
                                    $program_id = $row['program_id'];
                                    $subject_id = $row['subject_id'];
                                    $subject_code = $row['subject_code'];
                                    $subject_description = $row['subject_description'];  
                                        
$response .= "
                                    <option value='$subject_id'>$subject_code: $subject_description</option>";

                                }              

$response .= " 
                            </select>";

$response .= "                         
                    </div>
                </div>";

                echo $response;
                exit;      

?>