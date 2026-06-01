<?php
session_start();
include("../config/db.php");

$dept = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM DEPARTMENT"));
$faculty = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM FACULTY"));
$student = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM STUDENT"));
$course = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM COURSE"));
?>

<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="../css/style.css">

<title>Dashboard</title>

</head>

<body>

<?php include("sidebar.php"); ?>
<div class="content">

<h1>College Management System</h1>

<h3>Admin Dashboard</h3>

<hr>

<a href="department.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h2><?php echo $dept; ?></h2>
<h3>Departments</h3>
</div>
</a>

<a href="faculty.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h2><?php echo $faculty; ?></h2>
<h3>Faculty</h3>
</div>
</a>

<a href="student.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h2><?php echo $student; ?></h2>
<h3>Students</h3>
</div>
</a>

<a href="course.php" style="text-decoration:none;color:inherit;">
<div class="card">
<h2><?php echo $course; ?></h2>
<h3>Courses</h3>
</div>
</a>

<div class="footer">
College Management System
</div>

</div>

</body>
</html>