<?php 

  $print = $_POST['print'];

 ?>

<!DOCTYPE html>
<html>
<head>
  <title>CMYCES | Print Subject List</title>

  <link rel="icon" href="../img/cmycis logo.png">
</head>
<body onload="window.print();">

<!----HEAD---->
 <table style="margin-left: 1%">
  <tr style="border: none;">
    <th><img src="../img/m_logo.jpg" style="width: 100px; margin-left: 10px;"></th>
    <th style="font-size: 30px;"> CATHOLIC MING YUAN COLLEGE 

      <p style="font-size: 15px; margin-left: -40px; margin-top: -5px;"> Hda Binitin Murcia, Negros Occidental Philippines</p> 

      <p style="font-size: 15px; margin-left: -45px; margin-top: -17px; color: blue;" >mingyuancollege@gmail.com | (034) 4413570</p>

    </th>
  </tr>
</table>
<!----HEAD---->

<h3 style="margin-bottom: -10px; text-align: center;"> <?php echo "$print"; ?> </h3>
<hr>


<table style="width: 100%; border-collapse: collapse; border: 1px solid black; text-align: center;">
  <thead style="text-align: center; background: yellow; " >
    <td style="height: 30px; font-weight: bold; border: 1px solid black; width: 10%;" > Course Code </td>
    <td style="height: 30px; font-weight: bold; border: 1px solid black; width: 30%; " > Description </td>
    <td style="height: 30px; font-weight: bold; border: 1px solid black; width: 1%;" > Units </td>
    <td style="height: 30px; font-weight: bold; border: 1px solid black; width: 30%;" > Pre-requisite </td>
    <td style="height: 30px; font-weight: bold; border: 1px solid black; width: 10%;" > Year </td>
    <td style="height: 30px; font-weight: bold; border: 1px solid black; width: 17%;" > Semester </td>
  </thead>

<?php  

include '../admin_classes/config.php';
$query = $connect->prepare("SELECT * FROM `manage_course` WHERE curriculum = '$print' ");
$query->execute();

$sub_insert = $query->fetchAll();

foreach ($sub_insert as $account) {

$num_que = $account['num_que']; 
$curriculum = $account['curriculum']; 
$course_code = $account['course_code'];  
$description = $account['description']; 
$unit  = $account['unit']; 
$pre_requisite = $account['pre_requisite']; 
$year_level = $account['year_level']; 
$semester = $account['semester']; 

print 
"
  <tr>
    <td style='border: 1px solid black; color: black; text-align: justify; text-align: center;' > $course_code </td>
    <td style='border: 1px solid black; color: black; text-align: justify; text-align: center;' > $description </td>
    <td style='border: 1px solid black; color: black; text-align: justify; text-align: center;' > $unit </td>
    <td style='border: 1px solid black; color: black; text-align: justify; text-align: center;' > $pre_requisite </td>
    <td style='border: 1px solid black; color: black; text-align: justify; text-align: center;' > $year_level </td>
    <td style='border: 1px solid black; color: black; text-align: justify; text-align: center;' > $semester </td>
  </tr>
";

}
?>
</tbody>
</table>
<!--------->

</body>
</html>