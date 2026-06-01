<?php

include("../config/db.php");

$id = $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM DEPARTMENT WHERE DEPID='$id'"
);

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $depname = $_POST['depname'];
    $location = $_POST['location'];

    mysqli_query(
        $conn,
        "UPDATE DEPARTMENT
         SET DEPNAME='$depname',
             LOCATION='$location'
         WHERE DEPID='$id'"
    );

    header("Location: department.php");
}

?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Department</title>

<link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="content">

<h2>Edit Department</h2>

<form method="POST">

Department Name

<br>

<input
type="text"
name="depname"
value="<?php echo $row['DEPNAME']; ?>"
required>

<br><br>

Location

<br>

<input
type="text"
name="location"
value="<?php echo $row['LOCATION']; ?>"
required>

<br><br>

<input
type="submit"
name="update"
value="Update Department">

</form>

<br>

<a href="department.php">
Back
</a>

</div>

</body>
</html>