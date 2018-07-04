<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>database</title>
</head>
<body>
    <form action="data.php" method="post">
    <h2>User Registration Form</h2>
    User Name: <input type="text" name="user_name" id=""><br><br>
    User Email: <input type="text" name="user_email" id=""><br><br>
    User Password: <input type="password" name="user_pass" id=""><br><br>
    <input type="submit" value="submit" name="submit">
    </form>
    <h2><a href="data.php?view">view  data</a></h2>
</body>
</html>
<?php
$con = mysqli_connect("localhost","root","","users");
if(isset($_POST['submit'])){
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_pass = $_POST['user_pass'];

    $insert_query = "insert into users_data (user_name,user_email,user_pass) value('$user_name','$user_email','$user_pass')";
    $run_query = mysqli_query($con,$insert_query);
    if($run_query){
        echo "<h2>registered successfully</h2>";
    }
}
?>
<?php
if(isset($_GET['view'])){
    echo "
    <table width='700' border='2'>
    <tr>
    <th>User No:</th>
    <th>User Name:</th>
    <th>User Email:</th>
    <th>User Password:</th>
    <th>Delete User:</th>
    <th>Edit User:</th>
    </tr>
    ";
    $select_users = "select * from users_data order by 1 ASC Limit 0,5";
    $run_users = mysqli_query($con,$select_users);
    while($row=mysqli_fetch_array($run_users)){
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        $user_email = $row['user_email'];
        $user_pass = $row['user_pass'];
        echo "
        <tr align='center'>
        <td>$user_id</td>
        <td>$user_name</td>
        <td>$user_email</td>
        <td>$user_pass</td>
        <td><a href='data.php?del=$user_id'>Delete</a></td>
        <td><a href='data.php?edit=$user_id'>Edit</a></td>
        </tr>
        ";
    }
    echo "</table>";
}
if(isset($_GET['del'])){
    $del_id = $_GET['del'];
    $delete_user = "delete from users_data where user_id=$del_id";
    $run_delete = mysqli_query($con,$delete_user);
    if($run_delete){
        echo "<script>alert('user deleted')</script>";
        echo "<script>window.open('data.php?view','_self')</script>";
    }
}
if(isset($_GET['edit'])){
    $edit_id = $_GET['edit'];
    $edit_user = "select * from users_data where user_id=$edit_id";
    $run_edit = mysqli_query($con,$edit_user);
    $row_user = mysqli_fetch_array($run_edit);
    $user_id = $row_user['user_id'];
    $user_name = $row_user['user_name'];
    $user_email = $row_user['user_email'];
    $user_pass = $row_user['user_pass'];
    echo "
    <h2>Edit Your Data</h2>
    <form action='' method='post'>
    <b>Edit Name</b><input type='text' name='u_name' value='$user_name'><br><br>
    <b>Edit email</b><input type='text' name='u_email' value='$user_email'><br><br>
    <b>Edit pass</b><input type='password' name='u_pass' value='$user_pass'><br><br>
    <input type='submit' name='update' value='update'>
    </form>
    ";
}
if(isset($_POST['update'])){
    $update_id = $user_id;
    $u_name = $_POST['u_name'];
    $u_email= $_POST['u_email'];
    $u_pass = $_POST['u_pass'];

    $update_user = "update users_data set user_name='$u_name',user_email='$u_email',user_pass='$u_pass' where user_id='$update_id'";
    $run_update = mysqli_query($con,$update_user);
    if($run_update){
        echo "<script>alert('user updated')</script>";
        echo "<script>window.open('data.php?view','_self')</script>";
    }
}
?>