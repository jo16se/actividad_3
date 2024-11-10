<?php
ob_start();
require_once 'config.php';

session_start();

if (isset($_SESSION['username'])) {
    header("location: home.php");
    exit();
}


if (isset($_POST['login'])) {
    
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
     
         if(password_verify($password, $row['password'])) {
                       
             $_SESSION['username'] = $username;
             header("location: home.php");
             exit();
         } else {
            echo '<script>alert("EPPP. Wrong user details");</script>';
         }
    } else {
        echo '<script>alert("Error en el login");</script>';
    }
}

if (isset($_POST['register'])) {

    if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['repeat_password'])) {
        echo '<script>alert("All field are mandatory!");</script>';
        return;
    } elseif ($_POST['password'] != $_POST['repeat_password']) {
        echo '<script>alert("Passwords do not match!");</script>';
    } else {
    
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<script>alert("Username already exists!");</script>';
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            $result = mysqli_query($connection, $query);
        

            if($result) {
                echo '<script>
                    alert("User registered successfully");
                    window.location.href = "index.php";
                </script>';
                exit();
                
                
            } else {
                echo '<script>alert("Error registering user");</script>';
            }
        }
    }
}

ob_end_flush()
?>
<!DOCTYPE html>  
<html>  
      <head>  
           <title>Introduction to PHP</title>  
           <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

           <link rel="stylesheet" href="styles.css"> 
           <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      </head>  
      <body>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <?php
            if(isset($_GET["action"]) == "register")
            {
            ?>
            <form method="post">
                <h1 class="text-center mb-4">Register</h1>
             <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" class="form-control" name="username"/>
                    <label class="form-label" for="username">Username</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" class="form-control" name="password" />
                    <label class="form-label" for="password">Password</label>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="repeat_password" class="form-control" name="repeat_password" />
                    <label class="form-label" for="password">Repeat Password</label>
                </div>
                <!-- Submit button -->
                    <input type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4" value="Register" name="register">
                <!-- Register buttons -->
                <div class="text-center">
                    <p>Registered? <a href="index.php">Login</a></p>
                </div>
            </form>
            <?php
            }
            else
            {
            ?>
            <form method="post">
                <h1 class="text-center mb-4">Login</h1>
             <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" class="form-control" name="username"/>
                    <label class="form-label" for="username">Username</label>
                </div>
                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" class="form-control" name="password" />
                    <label class="form-label" for="password">Password</label>
                </div>
                <!-- 2 column grid layout for inline styling -->
                <div class="row mb-4">
                    <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="rememberme" />
                        <label class="form-check-label" for="rememberme"> Remember me </label>
                    </div>
                    </div>
                    <div class="col">
                    <!-- Simple link -->
                    <a href="#!">Forgot password?</a>
                    </div>
                </div>
                <!-- Submit button -->
                <!-- Submit button -->
                    <input type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4" value="Login" name="login">
                <!-- Register buttons -->
                <div class="text-center">
                    <p>Not a member? <a href="index.php?action=register">Register</a></p>
                </div>
            </form>
        </div>  
    </body>
    <?php
    }
    ?>  
</html> 