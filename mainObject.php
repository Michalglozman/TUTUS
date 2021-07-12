<?php
    include 'db.php';
    include 'config.php';
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header('Location: ' .URL . 'login.php');
    }
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $user = $_SESSION["user_id"];
    $ride_id = $_GET["ride_id"];
    $query = "SELECT id as r_id,
                    distance,
                    DATE_FORMAT(date, '%d/%m/%Y') as date,
                    balance,
                    accident,
                    DATE_FORMAT(start_time, '%H:%i') as start_time,
                    DATE_FORMAT(end_time, '%H:%i') as end_time,
                    driverPoints,
                    driverInputPoints
            FROM  tbl_rides_209 
            WHERE id =$ride_id";
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <script src="js\scripts.js"></script>
        <link rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300&family=Roboto:wght@100&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="css\style.css">
        
       <meta charset="UTF-8" >
       <title>TUTUS</title>
    </head>
    <body>
        <div class="container-fluid">
            <header>
                <div class="row justify-content-end">
                    <div class="col-4"><h6 class="text-center">My Ride</h6></div>
                    <div class="col-4 ">
                         <a href="index.php" id="logo" >
                         </a>
                    </div>
                </div>
            </header>
         
            <div class="main">
                <div id=" map-container-google-2" class="z-depth-1-half map-container" >
                    <iframe src="https://maps.google.com/maps?q=chicago&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
                      style="border:0" allowfullscreen></iframe>
                  </div>
                  <div class="RideSummry">
                  <h2>Ride Summry</h2>
                  <p>The information below gives a quick and simple description of your ride data at <b><?php echo $row['date']?></b>.</p>
            
                  <table class="table tableSum" >
                      <tbody>
                          <tr class="text-center">
                              <td>
                                  <span class="dataSum"><b><?php echo $row['start_time']." - ".$row['end_time']?></b><br></span>
                                  <small>Time</small>
                              </td>
                              <td>
                                <span class="dataSum"><b><?php echo $row["distance"] ?></b><br></span>
                                <small>Dictance</small>
                            </td>
                            <td >
                                <span class="dataSum"><b><?php echo $rating?> Pts</b><br></span>
                                <small>Score</small>
                            </td>
                            <td >
                                <span class="dataSum"><?php
                                if($accident==1){
                                    echo "<span><b>Yes</b></span>";
                                }
                                else{
                                    echo "<span><b>No</b></span>";
                                } ?><br></span>
                                <small>Accident</small>
                            </td>
                          </tr>
                      </tbody>
                  </table>
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