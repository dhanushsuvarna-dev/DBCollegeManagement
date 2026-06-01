<?php
session_start();
include("../config/db.php");

if(isset($_POST['add']))
{
    $depname = $_POST['depname'];
    $location = $_POST['location'];

    $sql = "INSERT INTO DEPARTMENT(DEPNAME,LOCATION)
            VALUES('$depname','$location')";

    mysqli_query($conn,$sql);
}

?>

<!DOCTYPE html>
<head>
<title>Department Management</title>

<link rel="stylesheet" href="../css/style.css">

</head>
<body>
<?php include("sidebar.php"); ?>
<div class="content">



<h2>Department List</h2>
<form method="GET" style="margin-bottom:20px;">

<input
type="text"
name="search"
placeholder="Search Department">

<input
type="submit"
value="Search">

</form>
<table>

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Location</th>
    <th>Action</th>
</tr>

<?php

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = $_GET['search'];

    $result = mysqli_query(
        $conn,
        "SELECT * FROM DEPARTMENT
         WHERE DEPNAME LIKE '%$search%'
         OR LOCATION LIKE '%$search%'"
    );
}
else
{
    $result = mysqli_query(
        $conn,
        "SELECT * FROM DEPARTMENT"
    );
}

while($row=mysqli_fetch_assoc($result))
{
    echo "<tr>";

    echo "<td>".$row['DEPID']."</td>";
    echo "<td>".$row['DEPNAME']."</td>";
    echo "<td>".$row['LOCATION']."</td>";

    echo "<td>
    <a href='edit_department.php?id=".$row['DEPID']."'>
    Edit
    </a>
    <a href='delete_department.php?id=".$row['DEPID']."'>
    Delete
    </a>
    
    </td>";

    echo "</tr>";
}

?>

</table>
<h2>Add Department</h2>

<form method="POST" style="
background:white;
padding:20px;
border-radius:10px;
box-shadow:0px 2px 10px rgba(0,0,0,0.1);
width:400px;
">

Department Name:
<input type="text" name="depname" required>

<br><br>

Location:
<input type="text" name="location" required>

<br><br>

<input type="submit" name="add" value="Add Department">

</form>
<hr>
</div>
</body>
</html>