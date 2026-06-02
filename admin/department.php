```php
<?php
session_start();
include("../config/db.php");

/* ADD DEPARTMENT */
if(isset($_POST['add']))
{
    $depname = mysqli_real_escape_string($conn, $_POST['depname']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    $sql = "INSERT INTO DEPARTMENT(DEPNAME, LOCATION)
            VALUES('$depname', '$location')";

    mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Department Management</title>
    <link rel="stylesheet" href="../css/style.css">

    <style>
        .content{
            padding:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            margin-bottom:30px;
        }

        table th,
        table td{
            border:1px solid #ddd;
            padding:10px;
            text-align:left;
        }

        table th{
            background:#2c3e50;
            color:white;
        }

        .form-box{
            width:450px;
            background:white;
            padding:20px;
            border-radius:10px;
            box-shadow:0px 2px 10px rgba(0,0,0,0.1);
        }

        input[type=text]{
            width:100%;
            padding:10px;
            margin-top:5px;
            margin-bottom:15px;
        }

        input[type=submit]{
            padding:10px 20px;
            background:#3498db;
            color:white;
            border:none;
            cursor:pointer;
        }

        .search-box{
            margin-bottom:20px;
        }

        .action-btn{
            text-decoration:none;
            padding:5px 10px;
            color:white;
            border-radius:4px;
        }

        .edit{
            background:green;
        }

        .delete{
            background:red;
        }
    </style>
</head>

<body>

<?php include("sidebar.php"); ?>

<div class="content">

    <h2>Department List</h2>

    <form method="GET" class="search-box">

        <input
            type="text"
            name="search"
            placeholder="Search Department Name or Location"
            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

        <input type="submit" value="Search">

    </form>

    <table>

        <tr>
            <th>Department ID</th>
            <th>Department Name</th>
            <th>Location</th>
            <th>Action</th>
        </tr>

        <?php

        if(isset($_GET['search']) && $_GET['search'] != "")
        {
            $search = mysqli_real_escape_string($conn,$_GET['search']);

            $sql = "SELECT *
                    FROM DEPARTMENT
                    WHERE DEPNAME LIKE '%$search%'
                    OR LOCATION LIKE '%$search%'
                    ORDER BY DEPID";
        }
        else
        {
            $sql = "SELECT *
                    FROM DEPARTMENT
                    ORDER BY DEPID";
        }

        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_assoc($result))
        {
            echo "<tr>";

            echo "<td>".$row['DEPID']."</td>";
            echo "<td>".$row['DEPNAME']."</td>";
            echo "<td>".$row['LOCATION']."</td>";

            echo "<td>

            <a class='action-btn edit'
               href='edit_department.php?id=".$row['DEPID']."'>
               Edit
            </a>

            <a class='action-btn delete'
               href='delete_department.php?id=".$row['DEPID']."'
               onclick=\"return confirm('Delete this department?')\">
               Delete
            </a>

            </td>";

            echo "</tr>";
        }

        ?>

    </table>

    <h2>Add Department</h2>

    <div class="form-box">

        <form method="POST">

            <label>Department Name</label>

            <input
                type="text"
                name="depname"
                required>

            <label>Location</label>

            <input
                type="text"
                name="location"
                required>

            <input
                type="submit"
                name="add"
                value="Add Department">

        </form>

    </div>

</div>

</body>
</html>
