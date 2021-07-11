<?php
    include 'db.php';
    include 'config.php';
    session_start();
    // Log out
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["type"] === "logout") {
        $_SESSION['loggedin'] = false;
        header('Location: ' .URL . 'login.php');
    }

    //check if user is connected
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header('Location: ' .URL . 'login.php');
    }
    // Create connection
    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = $_SESSION["user_id"];

    $sql_query = "SELECT user_name,
                    user_email,
                    gender,
                    user_age,
                    user_phone,
                    emergency_name,
                    emergency_phone,
                    img
            FROM tbl_user_209
            WHERE id = " . $id;
    
    $result = mysqli_query($connection, $sql_query);
    $row = mysqli_fetch_assoc($result);
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>


        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="css\style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta charset="UTF-8" >
       <title>TUTUS-My ride</title>
    </head>
    <body>
        <div class="container-fluid">
        <header>
                    <div class="row justify-content-end">
                        <div class="col-4"><h6 class="text-center">Profile</h6></div>
                        <div class="col-4 ">
                            <a href="index.html" id="logo"></a>
                        </div>
                    </div>
            </header>
            <div class="main">

                <div class="profile-box center ">
                    <img class="center profile-img" title="profile_pic" alt="profile_pic" src="<?php echo $row['img'];?>">
                </div>
                    <h2 class="text-center profile-name">
                        <?php
                            echo $row['user_name'];
                        ?>

                    </h2>
                    <div class="row">
                        <div class="col-sm-3">
                            <p><b>Email:</b></p>
                        </div>
                        <div class="col-sm-3">
                            <p><?php
                             echo $row['user_email']; 
                             ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <p><b>Phone:</b></p>
                        </div>
                        <div class="col-sm-3">
                            <p>
                                <?php
                                    echo "0" . $row['user_phone']
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <p><b>Age:</b></p>
                        </div>
                        <div class="col-sm-3">
                            <p>
                                <?php
                                    echo $row['user_age']
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <p><b>Gender:</b></p>
                        </div>
                        <div class="col-sm-3">
                            <p>
                            <?php
                                    echo $row['gender']
                            ?>
                            </p>
                        </div>
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Emergency Contact
                            </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class = "card-body">
                            <div class="row">
                                    <div class="col-sm-3">
                                        <p><b>Name:</b></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p>
                                        <?php
                                            echo $row['emergency_name']
                                        ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p><b>Phone Number:</b></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <p>
                                        <?php
                                            echo "0" . $row['emergency_phone']
                                        ?>
                                        </p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        </div>

                      <div class="row mt-2">
                        <div class = "logout col-sm-3">
                                <form id="del" action = "#" method = "POST">
                                    <button type="submit" class="btn btn-danger">Log Out</button>
                                    <input type="hidden" name="type" value="logout">
                                </form>
                        </div>
                    </div>

                </div>
            </div>
            
            <footer class="footer fixed-bottom mt-lg-3 py-3 bg-light">
                <div class="container">
                    <ul id="footerNav" class="nav justify-content-center">
                        <li class="nav-item text-center " >
                          <a class="nav-link" href="index.php">
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
                          <li class="nav-item active text-center navSpace" >
                            <a class="nav-link " href="#">
                                <img class="center footerIcon" src="img/person.svg">
                                
                                <span class="navFooterText">Profile</span>
                              </a>
                          </li>
                      </ul>
                </div>
            </footer>
        </div>
    </body>
</html>