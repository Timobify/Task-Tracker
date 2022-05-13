<?php
session_start();
require_once '../connection.php';
if(!isset($_SESSION['uid']) && !isset($_SESSION['user']) && !isset($_SESSION['name'])) {
    header("location: ../index.php");
    exit;
}
if(!isset($_SESSION['status'])){
    $_SESSION['status'] = 'status';
}
$date1 = date("Y-m-d");
$tid = mysqli_real_escape_string($link,$_GET['ID']);

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($link,$_POST["title"]);
    $description = mysqli_real_escape_string($link,$_POST["description"]);
    $date =  mysqli_real_escape_string($link,$_POST["date"]);
    $status =  mysqli_real_escape_string($link,$_POST["status"]);
    $uid =  mysqli_real_escape_string($link,$_POST["uid"]);
    $id =  mysqli_real_escape_string($link,$_POST["id"]);

    $query = "UPDATE `task` SET `Title`='$title',`Description`='$description',
	    `Due_Date`='$date',`Status`='$status',`uid`='$uid'
	    WHERE `id` = ".$id."";
    $result = mysqli_query($link,$query);
    if($result != null ){
        $_SESSION['status'] = "success";
        header("Location: update.php?ID=".$id);
        exit();

    } else {
        $_SESSION['status'] = "alert";
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
    <script src="../../js/bootstrap.bundle.js"></script>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/jquery-3.6.0.min.js"></script>
    <title>Task Tracker</title>
</head>
<body>

<nav class="navbar navbar-light bg-light">
    <div class="container">
    <span class="navbar-brand mb-0 h1">Task Tracker</span>
    <span class="nav justify-content-around">User :<?php echo " {$_SESSION ['name']}"; ?></span>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link active" href="index.php">Home </a>
            </li>
            <li class="nav-item">
                <?php
                $ID = $_SESSION['uid'];
                $qry  = "SELECT * FROM `task` where uid='$ID' AND notify = 0;";
                $rt = mysqli_query($link, $qry);
                $nums = mysqli_num_rows($rt);
                ?>
                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal" class="nav-link position-relative">
                    Notifications
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo $nums ;?>+
                            <span class="visually-hidden">unread messages</span>
                          </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tasks.php">Tasks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
    </div>
</nav>

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Newly Assigned Tasks</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $notify = mysqli_query($link, "SELECT * FROM task WHERE uid = {$_SESSION['uid']} AND notify = '0' ORDER BY id ASC ")
                    or die(mysqli_error($link));
                    while($rows = mysqli_fetch_array($notify)){?>
                        <div class="contain">
                            <p class="text-start"><strong>Task Title</strong> <?php echo $rows['title']; ?></p>
                            <p class="text-start"><b>Description</b> <?php echo $rows['description']; ?></p>
                            <span class="text-end"><b>Due Date</b> <?php echo $rows['due_date']; ?></span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <?php
                    }    if(mysqli_num_rows($notify) == 0){
                        $no = "<div id='group'>
						                  <h3 class=' text-info list-group-item-heading'> No Notifications at the Moment </h3>
						               </div>";
                        echo $no;
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="notify.php" type="button" class="btn btn-primary">Mark as Read</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="page-header">
        <?php if($_SESSION['status'] == "alert"):?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Sorry the Task wasn't saved. Try again <a href="#" class="alert-link">Alert Link</a>.
            </div>
        <?php endif;?>
        <?php if($_SESSION['status'] == "success"):?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                Task successfully updated and assigned to a User. <a href="index.php" class="alert-link">Success Link</a>.
            </div>
        <?php endif;?>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-5">
            <p class="h3">Update Task</p> <p>Click here to view other <a href="index.php">Assigned Tasks</a></p>
            <?php
            $query = mysqli_query($link, "SELECT * FROM task WHERE id = '$tid'");
            $update = mysqli_fetch_assoc($query);
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <?php
                $query  = "SELECT * FROM user";
                $ret = mysqli_query($link, $query);
                ?>
                <input hidden type="text" name="id" value="<?php echo $update['id'];?>" required>
                <div class="mb-3">
                    <label for="titleV">Task Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $update['title'];?>" id="titleV" placeholder="Task Title">
                </div>
                <div class="mb-3">
                    <label for="descriptionV">Task Description</label>
                    <textarea class="form-control" name="description" rows="" cols="" aria-label="With textarea"><?php echo $update['description'];?></textarea>
                </div>
                <div class="mb-3">
                    <label for="dueDateV">Due Date</label>
                    <input type="date" class="form-control" value="<?php echo $update['due_date'];?>" name="date" id="dueDateV" >
                </div>
                <div class="mb-3">
                    <label for="dueDateV">Completion Status</label>
                    <select class="form-select" name="status" aria-label="Default select example">
                        <?php if($update['status'] == 0): ?>
                        <option value="0" selected>Incomplete</option>
                        <option value="1">Complete</option>
                        <?php endif;?>
                        <?php if($update['status'] == 1): ?>
                            <option value="0">Incomplete</option>
                            <option value="1" selected>Complete</option>
                        <?php endif;?>
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
                <button type="submit" name="submit" class="btn btn-primary">Update Tasks</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('input.status').on('change', function () {
            var decision = $(this).val();
            var id = $('td.myvalue').html();
            alert(decision);
            alert(id);
            $.ajax({
                type: "POST",
                url: "/CodeIgniter/users/Users/update",
                data: {decision: decision, id: id},
                success: function (msg) {

                    $('#autosavenotify').text(msg);
                }
            })
        });
    });

</script>
</body>
</html>

