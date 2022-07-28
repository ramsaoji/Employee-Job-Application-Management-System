<?php
session_start();
include('db.php');
if(isset($_POST['login']))
{
    $uname=$_POST['user'];
    $password=md5($_POST['pass']);
    $sql ="SELECT login_name,login_pass,user_name,role FROM login WHERE login_name=:uname and login_pass=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    // print_r($results[0]->user_name);
    // echo '<script>console.log('.$results.')</script>';
    if($query->rowCount() > 0)
    {
        $_SESSION['user_name'] = $results[0]->user_name;
        // $_SESSION['login_name'] = $results[0]->login_name;
        $_SESSION['alogin']=$_POST['user'];

        $_SESSION['role'] = $results[0]->role;
        if($_SESSION['role'] == 'admin'){
            echo "<script type='text/javascript'> document.location = 'main/new_employee.php'; </script>";
        }else{
            echo "<script type='text/javascript'> document.location = 'main/reports_user.php'; </script>";
        }
        
    } else{
        
        echo "<script>alert('Invalid Details');</script>";

    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/login_css/loginstyle.css">
    <title>Ems Admin</title>
</head>

<body>
    <div class="login-wrapper">
        <form method="post" class="form">
            <img src="assets/img/avatar1.jpg" alt="">
            <h2>Ems Login</h2>
            <div class="input-group">
                <input type="text" name="user" id="loginUser" autocomplete="off" required>
                <label for="loginUser">User Name</label>
            </div>
            <div class="input-group">
                <input type="password" name="pass" id="loginPassword" autocomplete="off" required>
                <label for="loginPassword">Password</label>
            </div>
            <input name="login" type="submit" value="login" class="submit-btn">
        </form>

    </div>
</body>

</html>