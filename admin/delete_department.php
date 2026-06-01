<?php

include("../config/db.php");

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $checkFaculty = mysqli_query(
        $conn,
        "SELECT * FROM FACULTY WHERE DEPID='$id'"
    );

    $checkStudent = mysqli_query(
        $conn,
        "SELECT * FROM STUDENT WHERE DEPID='$id'"
    );

    $checkCourse = mysqli_query(
        $conn,
        "SELECT * FROM COURSE WHERE DEPID='$id'"
    );

    if(
        mysqli_num_rows($checkFaculty) > 0 ||
        mysqli_num_rows($checkStudent) > 0 ||
        mysqli_num_rows($checkCourse) > 0
    )
    {
        echo "<h3>Cannot Delete Department</h3>";
        echo "Department is being used by Faculty, Students or Courses.";
        echo "<br><br>";
        echo "<a href='department.php'>Go Back</a>";
        exit();
    }

    mysqli_query(
        $conn,
        "DELETE FROM DEPARTMENT WHERE DEPID='$id'"
    );

    header("Location: department.php");
}

?>