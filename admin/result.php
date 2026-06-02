<?php
session_start();
include("../config/db.php");

/* ADD RESULT */

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

<h2>View Results</h2>

<!-- FILTER BY DEPARTMENT + COURSE -->

<form method="GET">

<h3>Department & Course Wise Result</h3>

Department

<br>

<select name="depid" required>

<option value="">Select Department</option>

<?php
$result = mysqli_query($conn,"SELECT * FROM DEPARTMENT");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['DEPID']."'>".$row['DEPNAME']."</option>";
}
?>

</select>

<br><br>

Course

<br>

<select name="filtercourse" required>

<option value="">Select Course</option>

<?php
$result = mysqli_query($conn,"SELECT * FROM COURSE");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['COURSEID']."'>".$row['COURSENAME']."</option>";
}
?>

</select>

<br><br>

<input type="submit" name="view_dept_course" value="View Results">

</form>

<hr>

<!-- FILTER BY USN -->

<form method="GET">

<h3>Student Wise Result</h3>

USN

<br>

<select name="studentusn" required>

<option value="">Select Student</option>

<?php
$result = mysqli_query($conn,"SELECT * FROM STUDENT");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['USN']."'>".$row['USN']." - ".$row['NAME']."</option>";
}
?>

</select>

<br><br>

<input type="submit" name="view_student" value="View Student Result">

</form>

<hr>

<h2>Result Details</h2>

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

/* DEPARTMENT + COURSE FILTER */

if(isset($_GET['view_dept_course']))
{
    $depid = $_GET['depid'];
    $courseid = $_GET['filtercourse'];

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

    WHERE STUDENT.DEPID='$depid'
    AND EXAM_RESULT.COURSEID='$courseid'
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
}

/* STUDENT FILTER */

if(isset($_GET['view_student']))
{
    $usn = $_GET['studentusn'];

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

    WHERE EXAM_RESULT.USN='$usn'
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
}

?>

</table>

<hr>

<h2>Add Result</h2>

<form method="POST">

Student

<br>

<select name="usn" required>

<?php
$result = mysqli_query($conn,"SELECT * FROM STUDENT");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['USN']."'>".$row['USN']." - ".$row['NAME']."</option>";
}
?>

</select>

<br><br>

Course

<br>

<select name="courseid" required>

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

</div>

</body>
</html>