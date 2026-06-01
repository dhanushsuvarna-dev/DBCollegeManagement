<?php
session_start();
include("../config/db.php");

if(isset($_POST['add']))
{
    $coursename = $_POST['coursename'];
    $credits = $_POST['credits'];
    $facultyid = $_POST['facultyid'];
    $depid = $_POST['depid'];

    $sql = "INSERT INTO COURSE
    (COURSENAME,CREDITS,FACULTYID,DEPID)
    VALUES
    ('$coursename','$credits','$facultyid','$depid')";

    mysqli_query($conn,$sql);
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Course Management</title>

<link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include("sidebar.php"); ?>


<div class="content">



<h2>Course List</h2>
<form method="GET" style="margin-bottom:20px;">

<input
type="text"
name="search"
placeholder="Search Course">

<input
type="submit"
value="Search">

</form>
<table>

<tr>

<th>ID</th>
<th>Course Name</th>
<th>Credits</th>
<th>Faculty</th>
<th>Department</th>

</tr>

<?php

$sql = "
SELECT
COURSE.COURSEID,
COURSE.COURSENAME,
COURSE.CREDITS,
FACULTY.NAME AS FACULTYNAME,
DEPARTMENT.DEPNAME

FROM COURSE

JOIN FACULTY
ON COURSE.FACULTYID = FACULTY.FID

JOIN DEPARTMENT
ON COURSE.DEPID = DEPARTMENT.DEPID
";

$result = mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
    echo "<tr>";

    echo "<td>".$row['COURSEID']."</td>";
    echo "<td>".$row['COURSENAME']."</td>";
    echo "<td>".$row['CREDITS']."</td>";
    echo "<td>".$row['FACULTYNAME']."</td>";
    echo "<td>".$row['DEPNAME']."</td>";

    echo "</tr>";
}
if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = $_GET['search'];

    $sql = "
    SELECT
    COURSE.COURSEID,
    COURSE.COURSENAME,
    COURSE.CREDITS,
    FACULTY.NAME AS FACULTYNAME,
    DEPARTMENT.DEPNAME

    FROM COURSE

    JOIN FACULTY
    ON COURSE.FACULTYID = FACULTY.FID

    JOIN DEPARTMENT
    ON COURSE.DEPID = DEPARTMENT.DEPID

    WHERE COURSE.COURSENAME LIKE '%$search%'
    OR FACULTY.NAME LIKE '%$search%'
    OR DEPARTMENT.DEPNAME LIKE '%$search%'
    ";
}
else
{
    $sql = "
    SELECT
    COURSE.COURSEID,
    COURSE.COURSENAME,
    COURSE.CREDITS,
    FACULTY.NAME AS FACULTYNAME,
    DEPARTMENT.DEPNAME

    FROM COURSE

    JOIN FACULTY
    ON COURSE.FACULTYID = FACULTY.FID

    JOIN DEPARTMENT
    ON COURSE.DEPID = DEPARTMENT.DEPID
    ";
}

$result = mysqli_query($conn,$sql);
?>

</table>
<h2>Add Course</h2>

<form method="POST">

Course Name:

<br>

<input type="text" name="coursename" required>

<br><br>

Credits:

<br>

<input type="number" name="credits" required>

<br><br>

Faculty:

<br>

<select name="facultyid">

<?php

$result = mysqli_query($conn,"SELECT * FROM FACULTY");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['FID']."'>".$row['NAME']."</option>";
}

?>

</select>

<br><br>

Department:

<br>

<select name="depid">

<?php

$result = mysqli_query($conn,"SELECT * FROM DEPARTMENT");

while($row=mysqli_fetch_assoc($result))
{
    echo "<option value='".$row['DEPID']."'>".$row['DEPNAME']."</option>";
}

?>

</select>

<br><br>

<input type="submit" name="add" value="Add Course">

</form>

<hr>
</div>

</body>
</html>