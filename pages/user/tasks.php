<?php
session_start();
require_once '../connection.php';
$status = null;
if(!isset($_SESSION['uid']) && !isset($_SESSION['user']) && !isset($_SESSION['name'])) {
    header("location: ../index.php");
    exit;
}
if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($link,$_POST["title"]);
    $description = mysqli_real_escape_string($link,$_POST["description"]);
    $date =  mysqli_real_escape_string($link,$_POST["date"]);
    $status =  mysqli_real_escape_string($link,$_POST["status"]);
    $uid =  mysqli_real_escape_string($link,$_POST["uid"]);

    $query = "INSERT into task (Title, Description, Due_Date, Status, uid) values
    ('$title','$description','$date','$status','$uid')";
    $result = mysqli_query($link,$query);
    if($result != null ){
        $status = "success";
    } else {
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
    <link rel="stylesheet" type="text/css" media="screen" href="../../css/bootstrap.min.css" />
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <title>Task Tracker</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">Task Tracker</span>
    <span class="nav justify-content-around">User :<?php echo " {$_SESSION ['name']}"; ?></span>
</nav>
<nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" href="tasks.php">Tasks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h2>Create Task</h2>
    <br>
    <div class="page-header">
        <?php if($status == "alert"):?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Sorry the Task wasn't saved. Try again <a href="#" class="alert-link">Alert Link</a>.
            </div>
        <?php endif;?>
        <?php if($status == "success"):?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Task successfully created and assigned to a User. <a href="index.php" class="alert-link">Success Link</a>.
            </div>
        <?php endif;?>
    </div>
    <form class="py-4 py-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <?php
        $query  = "SELECT * FROM user";
        $ret = mysqli_query($link, $query);
        ?>
        <div class="mb-3">
            <label for="titleV">Task Title</label>
            <input type="text" class="form-control" name="title" id="titleV" placeholder="Task Title">
        </div>
        <div class="mb-3">
            <label for="descriptionV">Task Description</label>
            <textarea class="form-control" name="description" aria-label="With textarea"></textarea>
        </div>
        <div class="mb-3">
            <label for="dueDateV">Due Date</label>
            <input type="date" class="form-control" name="date" id="dueDateV" >
        </div>
        <div class="mb-3">
            <label for="dueDateV">Due Date</label>
            <select class="form-select" name="status" aria-label="Default select example" hidden>
                <option value="0" selected>Incomplete</option>
                <option value="1">Complete</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="assigned">Assign to User</label>
            <select class="form-select" name="uid" aria-label="Default select example">
                <?php
                while ($row = mysqli_fetch_array ($ret, MYSQLI_ASSOC)) {
                    ?>
                    <option value="<?php echo $row["uid"];?>"> <?php echo "".$row["name"]."";?> </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Create Tasks</button>
    </form>
</div>
</body>
</html>