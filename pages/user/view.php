<?php
session_start();
require_once '../connection.php';
if(!isset($_SESSION['uid']) && !isset($_SESSION['user']) && !isset($_SESSION['name'])) {
    header("location: ../index.php");
    exit;
}
$status = null;
$date1 = date("Y-m-d");
$_SESSION['taskID'] = $_GET["ID"];
if (isset($_POST['submit'])) {
    $taskid = mysqli_real_escape_string($link, $_POST["tasks"]);
    $userID = mysqli_real_escape_string($link,$_POST["user"]);
    $commenter = mysqli_real_escape_string($link, $_POST["fullname"]);
    $details= mysqli_real_escape_string($link,$_POST["comment"]);
    $DateTime = date("Y/m/d");
    $query = "INSERT INTO comments (tid, uid, commenter, details, datetime) values
		('$taskid','$userID','$commenter','$details','$date')";
    $result = mysqli_query($link,$query);
    header("Location: view.php?ID=".$taskid);
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../css/style.css" />
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
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
            <li class="nav-item active">
                <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tasks.php">Tasks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h2>View Task</h2>
    <?php
    $query  = "SELECT * FROM task WHERE id ={$_SESSION['taskID']}";
    $ret = mysqli_query($link, $query);
    $get = mysqli_fetch_assoc($ret);
    ?>
    <h4>TASK TITLE: <?php echo $get['title'];?></h4>
    <p><strong>DESCRIPTION:</strong> <?php echo $get['description'];?></p>
    <p><strong>Completion Status:</strong> <?php if($get['status'] == 0) {
        echo "Incomplete";} elseif ($get['status'] == 1){ echo "Complete";}?></p>
    <br>
    <?php
    $comments = mysqli_query($link, "SELECT * FROM comments WHERE tid = {$_SESSION['taskID']} ORDER BY cid ASC ")
    or die(mysqli_error($link));
    while($rows = mysqli_fetch_array($comments)){?>
        <div class="contain">
            <p class="text-start"><strong><?php echo $rows['commenter']; ?></strong></p>
            <p class="text-start"><?php echo $rows['details']; ?></p>
            <span class="text-end"><?php echo $rows['datetime']; ?></span>
        </div>
    <?php
    }    if(mysqli_num_rows($comments) == 0){
        $no = "<div id='group'>
						<h3 class=' text-info list-group-item-heading'> No Comments </h3></div>";
        echo $no;
        }
    ?>
    <br>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <div class="container">
            <input type="hidden" name="tasks" value="<?php echo "{$_SESSION['taskID']}";?>" >
            <input type="hidden" name="user" value="<?php echo "{$_SESSION['uid']}";?>" >
            <div class="form-group">
                <label><b>Your Name : <?php echo "{$_SESSION['name']} ";?></b></label>
                <input class="form-control" name="fullname" type="hidden" value="<?php echo "{$_SESSION['name']}";?>">
            </div >
            <div class="form-group">
                <label for="Description">Your Comment</label>
                <textarea class="form-control" name="comment" rows="3" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Comment</button>
        </div>
    </form>
</div>
</body>
</html>
