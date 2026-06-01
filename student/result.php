<?php

include("../config/db.php");

?>

<!DOCTYPE html>
<html>
<head>

<title>Results</title>

<link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="content">

<h2>Exam Results</h2>

<table>

<tr>
<th>Student</th>
<th>Course</th>
<th>Marks</th>
<th>Grade</th>
</tr>

<?php

$sql="
SELECT
STUDENT.NAME,
COURSE.COURSENAME,
EXAM_RESULT.MARKSOBTAINED,
EXAM_RESULT.GRADE

FROM EXAM_RESULT

JOIN STUDENT
ON EXAM_RESULT.USN=STUDENT.USN

JOIN COURSE
ON EXAM_RESULT.COURSEID=COURSE.COURSEID
";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{
    echo "<tr>";

    echo "<td>".$row['NAME']."</td>";
    echo "<td>".$row['COURSENAME']."</td>";
    echo "<td>".$row['MARKSOBTAINED']."</td>";
    echo "<td>".$row['GRADE']."</td>";

    echo "</tr>";
}

?>

</table>

</div>

</body>
</html>