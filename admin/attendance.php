<?php
session_start();
include("../config/db.php");

/* ADD ATTENDANCE */

if(isset($_POST['add']))
{
    $date = $_POST['date'];
    $usn = $_POST['usn'];
    $courseid = $_POST['courseid'];
    $status = $_POST['status'];

    $sql = "INSERT INTO ATTENDANCE
            (DATE, USN, COURSEID, STATUS)
            VALUES
            ('$date','$usn','$courseid','$status')";

    mysqli_query($conn,$sql);
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Attendance Management</title>

<link rel="stylesheet" href="../css/style.css">

</head>

<body>

<?php include("sidebar.php"); ?>

<div class="content">

<h2>View Attendance</h2>

<form method="GET">

<label>Course</label>
<br>

<select name="courseid" required>

<option value="">Select Course</option>

<?php

$result = mysqli_query($conn,"SELECT * FROM COURSE");

while($row = mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['COURSEID']."'>".$row['COURSENAME']."</option>";
}

?>

</select>

<br><br>

<label>Date</label>
<br>

<input type="date" name="date" required>

<br><br>

<input type="submit" name="view" value="View Attendance">

</form>

<hr>

<?php

if(isset($_GET['view']))
{
    $courseid = $_GET['courseid'];
    $date = $_GET['date'];

    echo "<h2>Attendance Records</h2>";

    echo "<table>";

    echo "<tr>
            <th>USN</th>
            <th>Name</th>
            <th>Department</th>
            <th>Course</th>
            <th>Date</th>
            <th>Status</th>
          </tr>";

    $sql = "
    SELECT
        ATTENDANCE.USN,
        STUDENT.NAME AS STUDENTNAME,
        DEPARTMENT.DEPNAME,
        COURSE.COURSENAME,
        ATTENDANCE.DATE,
        ATTENDANCE.STATUS

    FROM ATTENDANCE

    JOIN STUDENT
    ON ATTENDANCE.USN = STUDENT.USN

    JOIN DEPARTMENT
    ON STUDENT.DEPID = DEPARTMENT.DEPID

    JOIN COURSE
    ON ATTENDANCE.COURSEID = COURSE.COURSEID

    WHERE ATTENDANCE.COURSEID='$courseid'
    AND ATTENDANCE.DATE='$date'

    ORDER BY STUDENT.NAME
    ";

    $result = mysqli_query($conn,$sql);

    while($row = mysqli_fetch_assoc($result))
    {
        echo "<tr>";

        echo "<td>".$row['USN']."</td>";
        echo "<td>".$row['STUDENTNAME']."</td>";
        echo "<td>".$row['DEPNAME']."</td>";
        echo "<td>".$row['COURSENAME']."</td>";
        echo "<td>".$row['DATE']."</td>";

        if($row['STATUS'] == 'Present')
        {
            echo "<td style='color:green;font-weight:bold'>Present</td>";
        }
        else
        {
            echo "<td style='color:red;font-weight:bold'>Absent</td>";
        }

        echo "</tr>";
    }

    echo "</table>";
}

?>

<hr>

<h2>Mark Attendance</h2>

<form method="POST">

<label>Date</label>
<br>

<input type="date" name="date" required>

<br><br>

<label>Student</label>
<br>

<select name="usn" required>

<option value="">Select Student</option>

<?php

$result = mysqli_query($conn,"SELECT * FROM STUDENT");

while($row = mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['USN']."'>".$row['USN']." - ".$row['NAME']."</option>";
}

?>

</select>

<br><br>

<label>Course</label>
<br>

<select name="courseid" required>

<option value="">Select Course</option>

<?php

$result = mysqli_query($conn,"SELECT * FROM COURSE");

while($row = mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['COURSEID']."'>".$row['COURSENAME']."</option>";
}

?>

</select>

<br><br>

<label>Status</label>
<br>

<select name="status" required>
    <option value="Present">Present</option>
    <option value="Absent">Absent</option>
</select>

<br><br>

<input type="submit" name="add" value="Save Attendance">

</form>

</div>

</body>
</html>