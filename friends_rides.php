<?php
    include 'db.php';
    include 'config.php';
    session_start();
    //check if user is connected
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header('Location: ' .URL . 'login.php');
    }
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $user = $_SESSION["user_id"];
    $query = "SELECT user.user_name as user_name,
                    user.id as user_id
            FROM tbl_user_209 as user
            WHERE user.id!=$user;";
    $result = mysqli_query($connection, $query);
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {    

    $ride_id = $_POST["ride_id"];
    $points = $_POST["rate"];
    $query = "UPDATE tbl_rides_209
    SET driverInputPoints = $points
    WHERE id = $ride_id";
    
    $result = mysqli_query($connection, $query);
    header('Location: ' .URL . 'friends_rides.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="js/js_scripts.js"></script>
        <script src="js/slider.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" ></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css\style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta charset="UTF-8" >
       <title>TUTUS-Friends Rides</title>
    </head>
    <body>
        <div class="container-fluid">
            <header>
                    <div class="row justify-content-end">
                        <div class="col-4"><h6 class="text-center headerLine">Friends Rides</h6></div>
                        <div class="col-4 ">
                             <a href="index.html" id="logo" >
                             </a>
                        </div>
                    </div>
            </header>
        </div>          
        <div class="main">
            <div id="accordion">
            <?php
                 while($row = mysqli_fetch_assoc($result)) {
                echo "<div class\"card\">";
                echo  "<div class=\"card-header\" id=\"headingOne\">";
                echo  "<h5 class=\"mb-0\">";
                echo  "<button class=\"btn btn-link\" data-toggle=\"collapse\" data-target=\"#collapseOne".$row ["user_id"]."\" aria-expanded=\"true\" aria-controls=\"collapseOne".$row ["user_id"]."\">";
                echo  $row ["user_name"];
                echo  "</button>";
                echo  "</h5>";
                echo  "</div>";
                echo  "<div id=\"collapseOne".$row ["user_id"]."\" class=\"collapse\" aria-labelledby=\"headingOne\" data-parent=\"#accordion\">";
                echo  "<div class=\"card-body\">";
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                  $query = "SELECT rides.distance as distance,
                                  rides.date as date,
                                  rides.start_time as  start_time,
                                  rides.end_time as end_time,
                                  rides.driverPoints as driverPoints,
                                  rides.accident as accident,
                                  rides.driverInputPoints as driverInputPoints,
                                  rides.balance as balance,
                                  rides.id as ride_id
                          FROM tbl_rides_209 as rides
                          JOIN user_to_ride_209 as user_to_ride
                          ON rides.id = user_to_ride.ride_id
                          WHERE user_to_ride.user_id = ".$row["user_id"].
                          " ORDER BY rides.id desc LIMIT 3;";
                          
                  $result_rides = mysqli_query($connection, $query);
                  echo "<div class=\"table-responsive\">";
                  echo "<table class=\"table achiv-table table-striped\">";
                  echo "<tbody>";
                  echo "<tr>"; 
                  echo "<th>Date</th>";
                  echo "<th>Time</th>";
                  echo "<th>Points</th>";
                  echo "<th>Rate</th>";
                  echo "</tr>";
                  while($row_ride = mysqli_fetch_assoc($result_rides)) {
                    $rating=$row_ride['driverInputPoints'];
                    $accident=$row_ride['accident'];
                    $balance=100;
                    if($rating=== NULL){
                      $rating=100;
                    }
                    if($accident==0){
                      $accident=100;
                    }
                    if($row_ride['balance']==0){
                      $balance=0;
                    }
                    if($row_ride['balance']==1){
                      $balance=50;
                    }
                    if($row_ride['balance']==2){
                      $balance=100;
                    }
                    $rating=0.4*$row_ride["driverPoints"]+0.2*$rating+0.2*$accident+$balance*0.2;
                    echo "<tr>";
                    
                    echo "<td>";
                    echo $row_ride['date'];
                    echo "</td>";

                    echo "<td>";
                    echo $row_ride['start_time']."-".$row_ride['end_time'];;
                    echo "</td>";

                    echo "<td>";
                    echo $rating;
                    echo "</td>";
                    
                    echo "<td>";
                    echo "<button type=\"button\" class=\"btn btn-warning btn-sm open-AddNameUser\" data-toggle=\"modal\" data-target=\"#exampleModal\" data-date=\"".$row_ride["date"]."\" data-id=\"".$row_ride ["ride_id"]. "\" title=\"Rate\"><i class=\"fa fa-star-o\"></i></button>";
                    echo "</td>";

                    echo "</tr>";

                  }
                  echo "</tbody>";
                  echo "</table>";
                  echo  "</div>";
                }
                echo  "</div>";
                echo  "</div>";
                echo  "</div>";
                }
                ?>
              </div>
              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rate Ride</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="#" method="POST">
                      <div class="form-group">
                        <input type="number" name="ride_id" hidden class="form-control"  id="ride">
                      </div>
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Date:</label>
                        <input type="text" name="date" readonly class="form-control"  id="date">
                      </div>
                      <div class="form-group">
                        <label for="customRange1" class="col-form-label">Points:</label>
                        <input type="range" min="1" max="100" name="rate" value="50" class="slider" id="myRange">
                        <p>Value: <span id="demo"></span></p>
                      </div>
                      <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Rate</button>
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
                        <li class="nav-item text-center navSpace" >
                            <a class="nav-link" href="Myride.php">
                                <img class="center footerIcon" src="img/clock.svg">
                                
                                <span class="navFooterText">My Rides</span>
                              </a>
                          </li>
                          <li class="nav-item active text-center navSpace" >
                            <a class="nav-link" href="friends_rides.php">
                                <img class="center footerIcon" src="img/clipboard.svg">
                                
                                <span class="navFooterText">Friends Rides</span>
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