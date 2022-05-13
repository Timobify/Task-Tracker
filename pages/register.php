<?php
//session_start();
require_once 'connection.php';

$status = null;
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($link,$_POST["name"]);
    $username = mysqli_real_escape_string($link,$_POST["user"]);
    $password =  mysqli_real_escape_string($link,$_POST["psw"]);

    $query1 = "SELECT * FROM `user` WHERE `username` = '$username';";
    $result1 = mysqli_query($link,$query1);
    $num_rows1 = mysqli_num_rows($result1);

    if($num_rows1 == 0 ){
        $query = "INSERT into user (Username, Password, Name) values
        ('$username','$password','$name')";
        $result = mysqli_query($link,$query);
        $status = "success";
    }
    elseif ($num_rows1>= 1 ) {
        $status = "alert";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/check.js"></script>
    <title>Task Tracker</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">Task Tracker</span>
</nav>
<div class="container">
    <br>
    <div class="page-header">
        <?php if($status == "alert"):?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Sorry that Username is already in use. Try again <a href="#" class="alert-link">Alert Link</a>.
            </div>
        <?php endif;?>
        <?php if($status == "success"):?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Account successfully created. <a href="index.php" class="alert-link">Success Link</a>.
            </div>
        <?php endif;?>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-5">
        <h2>Register Here</h2>
        <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="mb-3">
                <label for="Fullname">Fullname</label>
                <input type="text" class="form-control" name="name" id="Fullname" placeholder="Your Fullname">
            </div>
            <div class="mb-3">
                <label for="Username">Username</label>
                <input type="text" class="form-control" name="user" id="Username" oninput="checkUsername()" placeholder="Your Username">
            </div>
            <div class="form-group" id="cU" ></div>
            <div class="mb-3">
                <label for="Password">Password</label>
                <input type="password" class="form-control" name="psw" id="Password" placeholder="Password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Register</button>
        </form>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="index.php">Already hava an Account? Log in</a>
        </div>
    </div>
</div>

</body>
</html>
