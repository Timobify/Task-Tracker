<?php
session_start();
require_once '../connection.php';
if(!isset($_SESSION['login_id']) && !isset($_SESSION['First_Name']) && !isset($_SESSION['Surname'])) {
    header("location: ../index.php");
    exit;
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
            <h1 class="display-7">You can view assigned Tasks from the system.</h1>
            <table class="table table-dark table-striped">
                <tr class="header">
                    <th onclick="sortTable(0)" class="button"><a >Task Title</a></th>
                    <th onclick="sortTable(1)" class="butten"><a >Description</a></th>
                    <th onclick="sortTable(2)" class="butten"><a >Due Date</a></th>
                    <th onclick="sortTable(3)" class="butten"><a >Status</a></th>
                </tr>
                <?php
                $ID = $_SESSION['login_id'];
                $query  = "SELECT * FROM `task` left join `assign` on task.id=assign.tid where uid='$ID';";
                $ret = mysqli_query($link, $query);
                $num_results = mysqli_num_rows($ret);
                for ($i = 0; $i < $num_results; $i++) {
                    $row = mysqli_fetch_array ($ret);
                    echo "<tr>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["due_date"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td><a class=\"butten\" href= update.php?ID=".$row['id'].">Update</a></td>";
                    echo "<td><a class=\"butten\" href= delete.php?ID=".$row['id'].">Delete</a></td>";
                    echo "</tr>";
                }if ($num_results==0) {
                    echo"<h3>No assigned tasks at the moment!</h3>";
                }
                echo "<caption>User {$_SESSION['Username']} can delete or view the {$num_results} assigned tasks</caption>";
                ?>
            </table>
        </div>
        <script>
            function myFunction() {
                // Declare variables
                var input, filter, table, tr, td, i;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

            function sortTable(n) {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.getElementById("myTable");
                switching = true;
                // Set the sorting direction to ascending:
                dir = "asc";
                /* Make a loop that will continue untilno switching has been done: */
                while (switching) {
                    // Start by saying: no switching is done:
                    switching = false;
                    rows = table.rows;
                    /* Loop throughall table rows (except thefirst, which contains table headers): */
                    for (i = 1; i < (rows.length - 1); i++) {
                        // Start by saying there should be no switching:
                        shouldSwitch = false;
                        /* Get the twoelements you wantto compare,one from current row and one from the next:*/
                        x = rows[i].getElementsByTagName("TD")[n];
                        y = rows[i + 1].getElementsByTagName("TD")[n];
                        /* Check if thetwo rows should switch place,based on the direction, asc or desc: */
                        if (dir =="asc") {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                // If so, mark as a switch and break the loop:
                                shouldSwitch= true;
                                break;}
                        } else if (dir =="desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                // If so, mark as a switch and break the loop:
                                shouldSwitch= true;break;}}}
                    if (shouldSwitch) {
                        /* If a switch has been marked, make the switchand mark that a switch has been done: */
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);switching = true;
                        // Each time aswitch is done, increase this countby 1:
                        switchcount++;} else {
                        /* If no switching has beendone AND the direction is "asc",set the direction
                        to "desc"and run the while loop again. */
                        if (switchcount== 0 && dir =="asc") {dir = "desc";switching = true;}}}}
        </script>
    </body>
</html>
