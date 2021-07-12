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
    $query = "SELECT rides.id as r_id, 
                    distance,
                    date,
                    balance,
                    accident,
                    DATE_FORMAT(start_time, '%H:%i') as start_time,
                    DATE_FORMAT(end_time, '%H:%i') as end_time,
                    driverPoints,
                    driverInputPoints
            FROM user_to_ride_209 AS user_to_ride
            JOIN tbl_rides_209 AS rides ON rides.id = user_to_ride.ride_id
            JOIN tbl_user_209 AS user ON user.id = user_to_ride.user_id
            WHERE user.id = " . $user .
             " ORDER BY r_id desc ";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
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
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="js/js_scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="css\style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta charset="UTF-8" >
       <title>TUTUS-Friends Ride</title>
    </head>
    <body>
        <div class="container-fluid">
            <header>
                <div class="row justify-content-end">
                    <div class="col-4"><h6 class="text-center">Home</h6></div>
                    <div class="col-4 ">
                         <a href="index.php" id="logo" >
                         </a>
                    </div>
                </div>
            </header>
            <br><br>
            <div hidden id="ratingDiv"><?php echo $rating; ?></div>
            <div class="main">
                <h5>Last Ride score:</h5>
                <div class="container-fluid w-50">
                            <canvas id="chDonut1"></canvas>
                            <span id="data-label"></span>
                            <?php
                            ?>
                </div>
                <hr>
                <h5>Your score compare to other users:</h5>
                <div class="container-fluid w-100">

                            <canvas id="bar1"></canvas>
                            </div>
                </div>
                <hr>
                <h5>Goals in progress:</h5>
                <div class="goals">
                    <i class='far fa-hand-paper' style='font-size:48px;color:rgb(0, 0, 0)'></i>
                </div>
                    <label>Sudden breaks</label>
                <br>
                <hr>
                <h5>My achievements:</h5>
                <div class="table-responsive">
                <table class="table achiv-table achievscooter ">
                    <thead></thead>
                    <tbody class="achiv-table">
                    <tr  class="text-center">
                        <td class="disabledRank text-center">
                            <img src="img/first scooter.svg">
                            <h6>Biggner</h6>
                        </td>
                      <td class="active text-center">
                       <img src="img/scooter yellow.svg">
                       <h6>Safe and sound</h6>
                      </td>
                      <td class="disabledRank text-center">
                        <img src="img/redscooter.svg">
                        <h6>fast like the Flash</h6>
                      </td>
                      
                      <td class="disabledRank text-center">
                        <img src="img/blue scooter.svg">
                        <h6>Advanced</h6>
                      </td>
                      
                      <td class="disabledRank text-center">
                        <img src="img/blue-yellow scooter.svg">
                        <h6>Royalty</h6>
                      </td>
                      
                    <td class="disabledRank text-center">
                        <img src="img/red-pur scooter.svg">
                        <h6>Pro</h6>
                    </td>
                    <td class="disabledRank text-center">
                        <img src="img/neon scooter.svg">
                        <h6>Expert</h6>
                    </td>
                </tr>
                </tbody>
                </table>
                </div>
                <div class="progress">
                    <div class="progress-bar colorBar" role="progressbar" style="width: <?php echo $row['driverPoints']?>%;" aria-valuenow="<?php echo $row['driverPoints']?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                <p> Your progress is at <?php echo $row['driverPoints']?>%, you have to gain feedbacks score to achieve the next level</p>
            </div>
            <hr>
            <br>
            <br>
        </div>
        <footer class="footer fixed-bottom mt-lg-3 py-3 bg-light">
            <div class="container">
                <ul id="footerNav" class="nav justify-content-center">
                    <li class="nav-item text-center active" >
                      <a class="nav-link" href="index.html">
                          <img class="center footerIcon" src="img/house-door.svg">
                          <span class="navFooterText">Home</span>
                        </a>
                    </li>
                    <li class="nav-item  text-center navSpace" >
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