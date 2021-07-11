
<?php
    include 'db.php';
    include 'config.php';
    session_start();
    //check if user is connected
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        header('Location: ' .URL . 'index.html');
    }
    $err_msg = "";
    if(!empty($_POST["email"])) {
        $query = "SELECT id
                    FROM tbl_user_209
                    WHERE
                        user_email = '". $_POST["email"]
                        . "'"
                        . "and user_pass = '"
                        . $_POST["pass"]
                        ."'";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($result);

        if(is_array($row)) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION['loggedin'] = true;
            header('Location: ' .URL . 'index.php');
        } else {
            $err_msg = "Invalide";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.82.0">
    <title>Signin TUTUS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="js\scripts.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="loginbody text-center"> 
    <main class="form-signin">
      <form action="#" method="POST">
        <img class="mb-4" src="img/TUTUS LOGO.svg" alt="" ><br>
        <p><b>Improve your e-scooter riding skills.</b></p>
        <div class="form-floating">
          <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
          <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
        </div>

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div >
        <div class="d-grid">
        <button class="w-100 btn btn-lg btn-primary" type="submit">Log-in</button><br>
        <div class="invalid-feedback">
            <?php
                echo $err_msg
            ?>
        </div>
        
        <p class="mt-5 mb-3 text-muted">&copy; TUTUS</p>
        </div> 
      </form>
    </main>
  </body>
</html>

