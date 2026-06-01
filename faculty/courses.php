<?php

include("../config/db.php");

?>

<!DOCTYPE html>
<html>
<head>

<title>Faculty Courses</title>

<link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="content">

<h2>All Courses</h2>

<table>

<tr>
<th>Course</th>
<th>Credits</th>
</tr>

<?php

$result = mysqli_query($conn,"SELECT * FROM COURSE");

while($row=mysqli_fetch_assoc($result))
{
    echo "<tr>";

    echo "<td>".$row['COURSENAME']."</td>";
    echo "<td>".$row['CREDITS']."</td>";

    echo "</tr>";
}

?>

</table>

</div>

</body>
</html>