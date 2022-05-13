<?php
session_start();
require_once 'connection.php';

$status = null;
if(isset( $_POST['Login'])){
    $username = $_POST ["user"];
    $password = $_POST ["psw"];

    if(isset( $username) && isset($password)){
        $userLogin = mysqli_real_escape_string ( $link, $username );
        $passwordLogin = mysqli_real_escape_string ( $link, $password );
        $query = "SELECT uid,`username`,`name` FROM `user` WHERE `username` = '$userLogin' AND `password` = '$passwordLogin' ";
        $result = mysqli_query ( $link, $query );
        $num_rows = mysqli_num_rows ( $result );

        if ($num_rows == 1) {
            echo "<script> alert(\"Login Successful\");</script>";
            $ret = mysqli_fetch_array ( $result );
            $_SESSION ['uid'] = $ret ['uid'];
            $_SESSION ['user'] = $ret ['username'];
            $_SESSION ['name'] = $ret ['name'];
            header ( "Location: user/index.php" );
        }
        elseif ($num_rows == 0) {
            $status = "alert";
        }
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
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        The Username or Password you entered is incorrect please try again. <a href="#" class="alert-link"> </a>.
                    </div>
                <?php endif;?>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-5">
                <h2>Log In</h2>
                <form class="py-4 py-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <div class="mb-3">
                        <label for="Username">Username</label>
                        <input type="text" class="form-control" name="user" id="Username" placeholder="your username">
                    </div>
                    <div class="mb-3">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" name="psw" id="Password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Remember Me</label>
                        </div>
                    </div>
                    <button type="submit" name="Login" class="btn btn-primary">Sign in</button>
                </form>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="register.php">New around here? Sign up</a>
                </div>
            </div>
        </div>

    </body>
</html>
