<?php
session_start();
include("../config/db.php");

/* Add Enrollment */

if(isset($_POST['add']))
{
    $usn = $_POST['usn'];
    $courseid = $_POST['courseid'];
    $academicyear = $_POST['academicyear'];
    $semester = $_POST['semester'];

    $sql = "INSERT INTO ENROLLMENT
    (USN, COURSEID, ACADEMICYEAR, SEMESTER)
    VALUES
    ('$usn','$courseid','$academicyear','$semester')";

    mysqli_query($conn,$sql);
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Enrollment Management</title>

<link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include("sidebar.php"); ?>

<div class="content">

<h2>View Enrollment</h2>

<form method="POST">

<label>Department</label>
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

<label>Course</label>
<br>

<select name="filter_courseid" required>

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

<input type="submit" name="filter" value="Show Enrollment">

</form>

<hr>

<?php

if(isset($_POST['filter']))
{
    $depid = $_POST['depid'];
    $courseid = $_POST['filter_courseid'];

    $sql = "
    SELECT
        ENROLLMENT.USN,
        STUDENT.NAME AS STUDENTNAME,
        DEPARTMENT.DEPNAME,
        COURSE.COURSENAME,
        ENROLLMENT.ACADEMICYEAR,
        ENROLLMENT.SEMESTER

    FROM ENROLLMENT

    JOIN STUDENT
        ON ENROLLMENT.USN = STUDENT.USN

    JOIN DEPARTMENT
        ON STUDENT.DEPID = DEPARTMENT.DEPID

    JOIN COURSE
        ON ENROLLMENT.COURSEID = COURSE.COURSEID

    WHERE DEPARTMENT.DEPID='$depid'
    AND COURSE.COURSEID='$courseid'
    ";

    $result = mysqli_query($conn,$sql);

    echo "<h2>Enrollment List</h2>";

    echo "<table>";

    echo "
    <tr>
        <th>USN</th>
        <th>Name</th>
        <th>Department</th>
        <th>Course</th>
        <th>Academic Year</th>
        <th>Semester</th>
    </tr>
    ";

    while($row=mysqli_fetch_assoc($result))
    {
        echo "<tr>";

        echo "<td>".$row['USN']."</td>";
        echo "<td>".$row['STUDENTNAME']."</td>";
        echo "<td>".$row['DEPNAME']."</td>";
        echo "<td>".$row['COURSENAME']."</td>";
        echo "<td>".$row['ACADEMICYEAR']."</td>";
        echo "<td>".$row['SEMESTER']."</td>";

        echo "</tr>";
    }

    echo "</table>";
}

?>

<hr>

<h2>Enroll Student</h2>

<form method="POST">

<label>Student</label>

<br>

<select name="usn" required>

<?php

$result = mysqli_query($conn,"SELECT * FROM STUDENT");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['USN']."'>".$row['NAME']." (".$row['USN'].")</option>";
}

?>

</select>

<br><br>

<label>Course</label>

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

<label>Academic Year</label>

<br>

<input type="text" name="academicyear" placeholder="2025-2026" required>

<br><br>

<label>Semester</label>

<br>

<input type="number" name="semester" min="1" max="8" required>

<br><br>

<input type="submit" name="add" value="Enroll">

</form>

</div>

</body>
</html>