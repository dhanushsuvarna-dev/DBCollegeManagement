<?php
session_start();
include("../config/db.php");

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

    mysqli_query($conn, $sql);
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

    <h2>Attendance Records</h2>

    <table>

        <tr>
            <th>USN</th>
            <th>Name</th>
            <th>Department</th>
            <th>Course</th>
            <th>Date</th>
            <th>Status</th>
        </tr>

        <?php

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
        ORDER BY ATTENDANCE.DATE DESC
        ";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>";

            echo "<td>".$row['USN']."</td>";
            echo "<td>".$row['STUDENTNAME']."</td>";
            echo "<td>".$row['DEPNAME']."</td>";
            echo "<td>".$row['COURSENAME']."</td>";
            echo "<td>".$row['DATE']."</td>";

            if($row['STATUS'] == "Absent")
            {
                echo "<td style='color:red;font-weight:bold;'>".$row['STATUS']."</td>";
            }
            else
            {
                echo "<td style='color:green;font-weight:bold;'>".$row['STATUS']."</td>";
            }

            echo "</tr>";
        }

        ?>

    </table>

    <h2>Mark Attendance</h2>

    <form method="POST">

        Date

        <br>

        <input type="date" name="date" required>

        <br><br>

        Student

        <br>

        <select name="usn" required>

            <?php

            $result = mysqli_query($conn, "SELECT * FROM STUDENT");

            while($row = mysqli_fetch_assoc($result))
            {
                echo "<option value='".$row['USN']."'>".$row['USN']." - ".$row['NAME']."</option>";
            }

            ?>

        </select>

        <br><br>

        Course

        <br>

        <select name="courseid" required>

            <?php

            $result = mysqli_query($conn, "SELECT * FROM COURSE");

            while($row = mysqli_fetch_assoc($result))
            {
                echo "<option value='".$row['COURSEID']."'>".$row['COURSENAME']."</option>";
            }

            ?>

        </select>

        <br><br>

        Status

        <br>

        <select name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select>

        <br><br>

        <input type="submit" name="add" value="Save Attendance">

    </form>

    <hr>

</div>

</body>
</html>