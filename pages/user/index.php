<?php
session_start();
require_once '../connection.php';
if(!isset($_SESSION['login_id']) && !isset($_SESSION['user']) && !isset($_SESSION['name'])) {
    header("location: ../index.php");
    exit;
}
$date1 = date("Y-m-d");
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
                    <li class="nav-item active">
                        <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
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
            <div class="row">
                <div class="col">
                    <div class="card p-3" style="width: 18rem;">
                        <div class="card-body">
                            <?php
                                $ID = $_SESSION['login_id'];
                                $query2  = "SELECT * FROM `task` where uid='$ID' AND status = 1;";
                                $ret2 = mysqli_query($link, $query2);
                                $num_results2 = mysqli_num_rows($ret2);
                            ?>
                            <h1 class="card-title"><?php echo $num_results2;?></h1>
                            <p class="card-text">Completed Tasks</p>
                            <a href="completedtasks.php" class="btn btn-primary">View Completed Tasks</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-3" style="width: 18rem;">
                        <div class="card-body">
                            <?php
                                $ID = $_SESSION['login_id'];
                                $query1  = "SELECT * FROM `task` where uid='$ID' AND status = 0 AND due_date >'$date1';";
                                $ret1 = mysqli_query($link, $query1);
                                $num_results1 = mysqli_num_rows($ret1);
                            ?>
                            <h1 class="card-title"><?php echo $num_results1;?></h1>
                            <p class="card-text">Incompleted Tasks</p>
                            <a href="#" class="btn btn-primary">View Incompleted Tasks</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-3" style="width: 18rem;">
                        <div class="card-body">
                            <?php
                                $ID = $_SESSION['login_id'];

                                $query3  = "SELECT * FROM `task` where uid='$ID'  AND status = 0 AND due_date <'$date1';";
                                $ret3 = mysqli_query($link, $query3);
                                $num_results3 = mysqli_num_rows($ret3);
                            ?>
                            <h1 class="card-title"><?php echo $num_results3;?></h1>
                            <p class="card-text">Over Due Tasks</p>
                            <a href="#" class="btn btn-primary">View Over Due Tasks</a>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="display-7">You can view assigned Tasks from the system.</h1>
            <table class="table table-dark table-striped">
                <tr class="header">
                    <th " class="button"><a >ID</a></th>
                    <th " class="button"><a >Task Title</a></th>
                    <th " class="butten"><a >Description</a></th>
                    <th " class="butten"><a >Due Date</a></th>
                    <th " class="butten"><a >Status</a></th>
                </tr>
                <?php
                $ID = $_SESSION['login_id'];
                $query  = "SELECT * FROM `task` where uid='$ID';";
                $ret = mysqli_query($link, $query);
                $num_results = mysqli_num_rows($ret);
                for ($i = 0; $i < $num_results; $i++) {
                    $row = mysqli_fetch_array ($ret);
                    ?>
                    <tr>
                        <?php $id = $row["id"]; ?>
                        <td class="myvalue"><?php echo $row["id"]; ?></td>
                        <td><?php echo $row["title"]; ?></td>
                        <td><?php echo $row["description"] ; ?></td>
                        <td><?php echo $row["due_date"] ; ?></td>
                        <input class="myid" type="hidden" value="<?php $id ?>" />
                        <td>
                            <?php if ($row["status"] == 0){ ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status" type="checkbox" value="1" role="switch" id="toggleBtn<?php $id ?>">
                                    <label class="form-check-label" for="toggleBtn<?php $id ?>">Set Task Complete</label>
                                </div>
                            <?php }
                            elseif ($row["status"] == 1){ ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input status" type="checkbox" role="switch" value="0" id="toggleBtn<?php $id ?>" checked>
                                    <label class="form-check-label" for="toggleBtn<?php $id ?>">Set Task Incomplete</label>
                                </div>
                            <?php } ?>
                        </td>
                        <td><a class="butten" href= view.php?ID= <?php echo $row['id'] ;?> >View</a></td>
                        <td><a class="butten" href= delete.php?ID= <?php echo $row['id'] ;?> >Delete</a></td>
                    </tr>
                <?php }if ($num_results==0) { ?>
                    <h3>No assigned tasks at the moment!</h3>
                <?php }
                echo "<caption>User {$_SESSION['user']} can delete or view the {$num_results} assigned tasks</caption>";
                ?>
            </table>
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