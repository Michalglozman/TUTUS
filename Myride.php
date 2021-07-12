<?php
    include 'db.php';
    include 'config.php';
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header('Location: ' .URL . 'login.php');
    }
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["type"] == "delete") {
    $user = $_SESSION["user_id"];
    $ride_id = $_POST["ride_id"];
    $query = "DELETE from user_to_ride_209 where ride_id = $ride_id";
    $result = mysqli_query($connection, $query);
    $query = "DELETE from tbl_rides_209 where id = $ride_id";
    $result = mysqli_query($connection, $query); 
    header('Location: ' .URL . 'Myride.php');
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["type"] == "update") {    
    $user = $_SESSION["user_id"];
    $ride_id = $_POST["rideId"];
    $distance = $_POST["distance"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $points = $_POST["points"];
    $is_accident = 0;
    $date = $_POST["date"];
    $balance = $_POST["balance"];
    if (isset($_POST["accident"]) )
    {
        $is_accident = 1;
    }
    $query = "UPDATE tbl_rides_209
    SET distance = $distance,
        start_time = '$start_time',
        end_time = '$end_time',
        date = '$date',
        accident = $is_accident,
        balance = $balance,
        driverPoints = $points
    WHERE id = $ride_id";
    
    $result = mysqli_query($connection, $query);
    header('Location: ' .URL . 'Myride.php');
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["type"] == "insert") {
    //form params
    $distance = $_POST["distance"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $points = $_POST["points"];
    $is_accident = 0;
    $date = $_POST["date"];
    $balance = $_POST["balance"];
    if (isset($_POST["accident"]) )
    {
        $is_accident = 1;
    }
    //Insert a new ride
    $query = "
    INSERT into tbl_rides_209 
        (distance,start_time,end_time,date,accident,balance,driverPoints)
    values 
        ($distance, '$start_time','$end_time', '$date',$is_accident,$balance,$points)";
    
    $result = mysqli_query($connection, $query);
   
    $query = "SELECT max(id) as id from tbl_rides_209";

    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $ride_id = $row["id"];
    $user_id = $_SESSION["user_id"];

    $query = "
    INSERT into  user_to_ride_209 (user_id,ride_id)
    VALUES ($user_id,$ride_id)";
    $result = mysqli_query($connection, $query);
    header('Location: ' .URL . 'Myride.php');
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $user = $_SESSION["user_id"];

    $query = "SELECT rides.id as r_id,distance,date,balance,accident,
                    DATE_FORMAT(start_time, '%H:%i') as start_time,
                    DATE_FORMAT(end_time, '%H:%i') as end_time,
                    driverPoints,
                    driverInputPoints
            FROM user_to_ride_209 AS user_to_ride
            JOIN tbl_rides_209 AS rides ON rides.id = user_to_ride.ride_id
            JOIN tbl_user_209 AS user ON user.id = user_to_ride.user_id
            WHERE user.id = " . $user . " ORDER BY r_id desc";
    $result = mysqli_query($connection, $query);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="js/js_scripts.js"></script>
        <script src="js/loadBalance.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" ></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css\style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta charset="UTF-8" >
       <title>TUTUS-My ride</title>
    </head>
    <body>
        <div class="container-fluid">
            <header>
                <div class="row justify-content-end">
                    <div class="col-4"><h5 class="text-center">My Ride</h5></div>
                    <div class="col-4 ">
                         <a href="index.php" id="logo" >
                         </a>
                    </div>
                </div>
            </header>
        </div>
            <div class="main">
                    <div class="container-fluid w-100 ml">
                        <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort By
                        </a>
                    
                        <button type="button" class="btn btn-info self-align-right addRide" data-toggle="modal" data-target="#rideModala" >Add ride</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" onclick='sortTable("ridesTable",0);'>Distance</a>
                            <a class="dropdown-item" href="#" onclick='sortTable("ridesTable",2);'>Points</a>
                        </div>
                        </div>
                    </div>
                  <br>

                <table id = "ridesTable" class="table tableRide mx-auto table-hover">
                    <tbody>
                        <?php
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            $rating=$row['driverInputPoints'];
                            $accident=$row['accident'];
                            $balance=100;
                            if($rating=== NULL){
                              $rating=100;
                            }
                            if($accident==0){
                              $accident=100;
                            }
                            if($row['balance']==0){
                              $balance=0;
                            }
                            if($row['balance']==1){
                              $balance=50;
                            }
                            if($row['balance']==2){
                              $balance=100;
                            }
                            $rating=0.4*$row["driverPoints"]+0.2*$rating+0.2*$accident+$balance*0.2;
                            echo "<tr class=\"mOver\">";
                            echo "<td class=\"text-center\" onclick=\" return redirect('mainObject.php?ride_id=".$row["r_id"]."')\">";
                            echo "<img src=\"img/cursor.svg\" width=\"25\" height=\"25\">";
                            echo "<h6>" ."<span id=\"value\">". $row['distance']. "</span> meters</h6>";
                            echo "<small>Distance</small>";
                            echo "</td>";
                            echo "<td class=\"text-center\" onclick=\" return redirect('mainObject.php?ride_id=".$row["r_id"]."')\">";
                            echo "<img src=\"img/clock.svg\" width=\"25\" height=\"25\">";
                            echo "<h6>". $row["start_time"] . " - ". $row["end_time"] ."</h6>";
                            echo "<small>Time</small>";
                            echo "</td>";
                            echo "<td class=\"text-center\" onclick=\" return redirect('mainObject.php?ride_id=".$row["r_id"]."')\">";
                            echo "<img src=\"img/star.svg\" width=\"25\" height=\"25\">";
                            echo "<h6>"."<span id=\"value\">". $rating ."</span> pts</h6>";
                            echo "<small>Score</small>";
                            echo "</td>";
                            echo "<td class=\"td-icon\">";
                            echo "<form id=\"del\" action = \"#\" method = \"POST\">";
                            echo "<button id=\"delBtn\" class=\"btn btn-danger btn-sm rounded-0\" title=\"delete\"><i class=\"fa fa-trash\"></i></button>";
                            echo " <input type=\"hidden\" name=\"ride_id\" value=\"".$row["r_id"]."\">";
                            echo " <input type=\"hidden\" name=\"type\" value=\"delete\">";
                            echo "</form>";
                            echo "</td>";
                            echo "<td class=\"td-icon\">";
                            echo "<button id=\"update\" type=\"button\" class=\"btn btn-success btn-sm rounded-0 open-Update\" data-toggle=\"modal\" data-target=\"#rideModala\"  
                                data-todo='{\"distance\":\"".$row["distance"]."\",
                                            \"points\":\"". $row["driverPoints"] ."\",
                                            \"start\":\"". $row["start_time"] ."\",
                                            \"end\":\"". $row["end_time"] ."\",
                                            \"date\":\"". $row["date"] ."\",
                                            \"balance\":\"". $row["balance"] ."\",
                                            \"ride\":\"". $row["r_id"] ."\",
                                            \"accident\":\"". $row["accident"] ."\"
                                        }'
                                            
                                            title=\"update\"><i class=\"fa fa-edit\"></i></button>";
                            echo "</td>";
                            echo "</tr>";

                        }
                        ?>
  
                    </tbody>
                </table>

             

                <div class="modal fade" id="rideModala" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add ride</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST">
                            <div class="form-group">
                                <label for="distance" class="col-form-label">Distance:</label>
                                <input id="distanceInput" type="number" name="distance" class="form-control" id="distance">
                            </div>
                            <div class="form-group">
                                <label for="start_time" class="col-form-label">Stat Time:</label>
                                <input id="startInput" type="time" name="start_time" class="form-control" id="start_time">
                            </div>
                            <div class="form-group">
                                <label for="end_time" class="col-form-label">End Time:</label>
                                <input id="endInput" type="time" name="end_time" class="form-control" id="end_time">
                            </div>
                            <div class="form-group">
                                <label for="date" class="col-form-label">Date:</label>
                                <input id="dateInput" type="date" name="date" class="form-control" id="date">
                            </div>
                            <div class="form-group">
                                <label for="points" class="col-form-label">Points:</label>
                                <input id="pointsInput" type="number" name="points" class="form-control" id="date">
                            </div>
                            <div class="form-group">
                                <label for="inputState">Balance</label>
                                <select name = "balance" id="inputState" class="form-control">

                                </select>
                            </div>
                            <div class="form-check">
                                <input id="accidentInput" class="form-check-input" name = "accident" type="checkbox" value="true" id="defaultCheck1">
                                <label class="form-check-label" for="accident">
                                    accident
                                </label>
                            </div>
                            <input id="actionInput" type="hidden" name="type" value="insert">
                            <input id="rideIdInput" type="hidden" name="rideId" >
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    
                    </div>
                 
                </div>
                </div>
            </div>
            </div>
            <footer class="footer fixed-bottom mt-auto py-3 bg-light">
                <div class="container">
                    <ul id="footerNav" class="nav justify-content-center">
                        <li class="nav-item text-center " >
                          <a class="nav-link" href="index.php">
                              <img class="center footerIcon" src="img/house-door.svg">
                              <span class="navFooterText">Home</span>
                            </a>
                        </li>
                        <li class="nav-item active text-center navSpace" >
                            <a class="nav-link" href="Myride.php">
                                <img class="center footerIcon" src="img/clock.svg">
                                <span class="navFooterText">My Rides</span>
                              </a>
                          </li>
                          <li class="nav-item text-center navSpace" >
                            <a class="nav-link" href="friends_rides.php">
                                <img class="center footerIcon" src="img/clipboard.svg">
                                <span class="navFooterText">Friends Ride</span>
                              </a>
                          </li>
                          <li class="nav-item text-center navSpace" >
                            <a class="nav-link " href="profile.php">
                                <img class="center footerIcon" src="img/person.svg">
                                
                                <span class="navFooterText">Profile</span>
                              </a>
                          </li>
                      </ul>
                </div>
            </footer>
    </body>
</html>