<?php
session_start();
include("../config/db.php");

if(isset($_POST['add']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $depid = $_POST['depid'];

    $sql = "INSERT INTO FACULTY(NAME,PHONE,DEPID)
            VALUES('$name','$phone','$depid')";

    mysqli_query($conn,$sql);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Department Management</title>

<link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include("sidebar.php"); ?>
<div class="content">
<h1>Faculty Management</h1>


<h2>Faculty List</h2>

<form method="GET" style="margin-bottom:20px;">

<input
type="text"
name="search"
placeholder="Search Faculty">

<input
type="submit"
value="Search">

</form>
<table border="1">

<tr>
    <th>Faculty ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Department</th>
</tr>

<?php

$sql = "
SELECT FACULTY.FID,
       FACULTY.NAME,
       FACULTY.PHONE,
       DEPARTMENT.DEPNAME
FROM FACULTY
JOIN DEPARTMENT
ON FACULTY.DEPID = DEPARTMENT.DEPID
";

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = $_GET['search'];

    $sql = "
    SELECT
    FACULTY.FID,
    FACULTY.NAME,
    FACULTY.PHONE,
    DEPARTMENT.DEPNAME

    FROM FACULTY

    JOIN DEPARTMENT
    ON FACULTY.DEPID = DEPARTMENT.DEPID

    WHERE FACULTY.NAME LIKE '%$search%'
    OR FACULTY.PHONE LIKE '%$search%'
    OR DEPARTMENT.DEPNAME LIKE '%$search%'
    ";
}
else
{
    $sql = "
    SELECT
    FACULTY.FID,
    FACULTY.NAME,
    FACULTY.PHONE,
    DEPARTMENT.DEPNAME

    FROM FACULTY

    JOIN DEPARTMENT
    ON FACULTY.DEPID = DEPARTMENT.DEPID
    ";
}

$result = mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
    echo "<tr>";

    echo "<td>".$row['FID']."</td>";
    echo "<td>".$row['NAME']."</td>";
    echo "<td>".$row['PHONE']."</td>";
    echo "<td>".$row['DEPNAME']."</td>";

    echo "</tr>";
}

?>

</table>
<h2>Add Faculty</h2>

<form method="POST" style="
background:white;
padding:20px;
border-radius:10px;
box-shadow:0px 2px 10px rgba(0,0,0,0.1);
width:400px;
">

Name:
<input type="text" name="name" required>

<br><br>

Phone:
<input type="text" name="phone" required>

<br><br>

Department:

<select name="depid">

<?php

$dept = mysqli_query($conn,"SELECT * FROM DEPARTMENT");

while($row=mysqli_fetch_assoc($dept))
{
    echo "<option value='".$row['DEPID']."'>".$row['DEPNAME']."</option>";
}

?>

</select>

<br><br>

<input type="submit" name="add" value="Add Faculty">

</form>

<hr>
</div>
</body>
</html>