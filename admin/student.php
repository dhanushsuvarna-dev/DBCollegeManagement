<?php
session_start();
include("../config/db.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['add']))
{
    $usn = $_POST['usn'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $depid = $_POST['depid'];

    mysqli_query($conn,"INSERT INTO STUDENT
    (USN,NAME,PHONE,DOB,EMAIL,DEPID)
    VALUES
    ('$usn','$name','$phone','$dob','$email','$depid')");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Management</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="content">



<h2>Student List</h2>

<form method="GET" style="margin-bottom:20px;">

<input
type="text"
name="search"
placeholder="Search Student"
value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

<input
type="submit"
value="Search">

</form>

<table>

<tr>
<th>USN</th>
<th>Name</th>
<th>Phone</th>
<th>DOB</th>
<th>Email</th>
<th>Department</th>
</tr>

<?php

$search = "";

if(isset($_GET['search']))
{
    $search = trim($_GET['search']);
}

$sql = "
SELECT
STUDENT.*,
DEPARTMENT.DEPNAME
FROM STUDENT
JOIN DEPARTMENT
ON STUDENT.DEPID = DEPARTMENT.DEPID
";

if($search != "")
{
    $sql .= "
    WHERE STUDENT.USN LIKE '%$search%'
    OR STUDENT.NAME LIKE '%$search%'
    OR STUDENT.EMAIL LIKE '%$search%'
    OR DEPARTMENT.DEPNAME LIKE '%$search%'
    ";
}

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result))
{
    echo "<tr>";

    echo "<td>".$row['USN']."</td>";
    echo "<td>".$row['NAME']."</td>";
    echo "<td>".$row['PHONE']."</td>";
    echo "<td>".$row['DOB']."</td>";
    echo "<td>".$row['EMAIL']."</td>";
    echo "<td>".$row['DEPNAME']."</td>";

    echo "</tr>";
}

?>

</table>


<h2>Add Student</h2>

<form method="POST">

USN <br>
<input type="text" name="usn" required><br><br>

Name <br>
<input type="text" name="name" required><br><br>

Phone <br>
<input type="text" name="phone" required><br><br>

DOB <br>
<input type="date" name="dob" required><br><br>

Email <br>
<input type="email" name="email" required><br><br>

Department <br>
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

<input type="submit" name="add" value="Add Student">

</form>

<hr>
</div>
</body>
</html>