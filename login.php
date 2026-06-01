<?php
session_start();
include("config/db.php");

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM LOGIN
            WHERE USERNAME='$username'
            AND PASSWORD='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $row = mysqli_fetch_assoc($result);

        $_SESSION['username'] = $row['USERNAME'];
        $_SESSION['role'] = $row['ROLE'];

        if($row['ROLE']=="Admin")
            header("Location: admin/dashboard.php");

        elseif($row['ROLE']=="Faculty")
            header("Location: faculty/dashboard.php");

        elseif($row['ROLE']=="Student")
            header("Location: student/dashboard.php");
    }
    else
    {
        echo "Invalid Login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>College Management System</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
}

.login-container{
    width:450px;
    background:#ffffff;
    padding:40px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.25);
}

.title{
    text-align:center;
    color:#1e3c72;
    font-size:34px;
    font-weight:700;
    margin-bottom:5px;
    letter-spacing:0.5px;
}

.subtitle{
    text-align:center;
    color:#2a5298;
    font-size:18px;
    font-weight:600;
    margin-bottom:30px;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    color:#333;
    font-size:14px;
    font-weight:600;
}

.form-group input{
    width:100%;
    padding:14px;
    border:1px solid #d1d5db;
    border-radius:10px;
    font-size:15px;
    transition:0.3s;
}

.form-group input:focus{
    outline:none;
    border-color:#2a5298;
    box-shadow:0 0 10px rgba(42,82,152,0.25);
}

.login-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    color:white;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.login-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(42,82,152,0.3);
}

.footer-text{
    text-align:center;
    margin-top:25px;
    color:#4b6cb7;
    font-size:15px;
    font-weight:600;
    letter-spacing:1px;
    text-transform:uppercase;
}

</style>

</head>

<body>

<div class="login-container">

    <div class="title">
        College Management System
    </div>

    <div class="subtitle">
        Admin Portal
    </div>

    <form method="POST">

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <input type="submit"
               name="login"
               value="Login"
               class="login-btn">

    </form>

    <div class="footer-text">
        Secure Login Access
    </div>

</div>

</body>
</html>