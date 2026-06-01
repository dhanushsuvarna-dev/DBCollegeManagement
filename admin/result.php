<?php
session_start();
include("../config/db.php");

if(isset($_POST['add']))
{
    $courseid = $_POST['courseid'];
    $usn = $_POST['usn'];
    $marks = $_POST['marks'];

    if($marks >= 90)
        $grade = 'A';
    elseif($marks >= 80)
        $grade = 'B';
    elseif($marks >= 70)
        $grade = 'C';
    elseif($marks >= 60)
        $grade = 'D';
    else
        $grade = 'F';

    $sql = "INSERT INTO EXAM_RESULT
    (COURSEID,USN,MARKSOBTAINED,GRADE)
    VALUES
    ('$courseid','$usn','$marks','$grade')";

    mysqli_query($conn,$sql);
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Result Management</title>

<link rel="stylesheet" href="../css/style.css">

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="content">



<h2>Results</h2>

<table>

<tr>
<th>USN</th>
<th>Name</th>
<th>Department</th>
<th>Course</th>
<th>Marks</th>
<th>Grade</th>
</tr>

<?php

$sql = "
SELECT
EXAM_RESULT.USN,
STUDENT.NAME AS STUDENTNAME,
DEPARTMENT.DEPNAME,
COURSE.COURSENAME,
EXAM_RESULT.MARKSOBTAINED,
EXAM_RESULT.GRADE

FROM EXAM_RESULT

JOIN STUDENT
ON EXAM_RESULT.USN = STUDENT.USN

JOIN DEPARTMENT
ON STUDENT.DEPID = DEPARTMENT.DEPID

JOIN COURSE
ON EXAM_RESULT.COURSEID = COURSE.COURSEID
";

$result = mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
    echo "<tr>";

    echo "<td>".$row['USN']."</td>";
    echo "<td>".$row['STUDENTNAME']."</td>";
    echo "<td>".$row['DEPNAME']."</td>";
    echo "<td>".$row['COURSENAME']."</td>";
    echo "<td>".$row['MARKSOBTAINED']."</td>";
    echo "<td>".$row['GRADE']."</td>";

    echo "</tr>";
}

?>

</table>
<h2>Add Result</h2>

<form method="POST">

Student

<br>

<select name="usn">

<?php

$result = mysqli_query($conn,"SELECT * FROM STUDENT");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['USN']."'>".$row['NAME']."</option>";
}

?>

</select>

<br><br>

Course

<br>

<select name="courseid">

<?php

$result = mysqli_query($conn,"SELECT * FROM COURSE");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['COURSEID']."'>".$row['COURSENAME']."</option>";
}

?>

</select>

<br><br>

Marks

<br>

<input type="number" name="marks" min="0" max="100" required>

<br><br>

<input type="submit" name="add" value="Save Result">

</form>

<hr>
</div>

</body>
</html>