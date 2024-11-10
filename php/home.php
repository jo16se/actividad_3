<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}
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
        <div class="container  align-middle my-4" style="min-height: 100vh;">
            <span>Welcome to my app!</span>

            <div class="row">

                <?php
                $query = "SELECT * FROM users";
                $result = mysqli_query($connection, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo
                        '
                        <div class="col-md-4 my-3">
                            <div class="card" style="width: 15rem;">
                            <div class="card-body">
                                <h5 class="card-title">Username: '.$row['username'].'</h5>
                                <h6 class="card-subtitle mb-2 text-muted">ID: '.$row['id'].'</h6>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                            </div>
                        </div>
                        ';
                    }
                }
                
                ?>
            
        </div>  

        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </body>  
</html> 