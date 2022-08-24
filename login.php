<?php
// Initialize the session
session_start();
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$user_name = $password = $device_name = $location = $longitude = $latitde = $floor ="";
$user_name_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["user_name"]))){
        $user_name_err = "Please enter username.";
    } else{
        $user_name = trim($_POST["user_name"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($user_name_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, user_name, password, device_name, location , floor, latitude, longitude FROM data WHERE user_name = ?";
        //device_name, floor, longitude, latitude , location
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_user_name);
            
            // Set parameters
            $param_user_name = $user_name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                     mysqli_stmt_bind_result($stmt, $id, $user_name, $hashed_password, $device_name, $location, $floor, $latitude, $longitude);
                     //$device_name, $location, $floor, $latitude, $longitude,

                    if(mysqli_stmt_fetch($stmt)){

                        if(password_verify($password, $hashed_password)){
                            // password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["user_name"] = $user_name;   
                            $_SESSION["device_name"] = $device_name;
                            $_SESSION["location"] = $location;  
                            $_SESSION["floor"] = $floor;  
                            $_SESSION["latitude"] = $latitude;  
                            $_SESSION["longitude"] = $longitude;                        
                            
                            // Redirect user to welcome page
                            header("location: untitled.php");
                        } else{
                            // password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log in</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; color: black; background-image: url(https://epd.eu/wp-content/uploads/2020/07/AdobeStock_204993923-1024x630.jpeg); background-position: center; background-repeat: no-repeat; background-attachment: fixed; background-size: 1707px 837px; }
        .wrapper{ position: fixed; width: 360px; height: 420px; margin: 5% auto; left: 0; right: 0; border: solid; padding: 10px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Join The National Power Meter Community</h2>
        <p>Please fill in your credentials to log in.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" aligh= "center">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="user_name" class="form-control <?php echo (!empty($user_name)) ? 'is-invalid' : ''; ?>" value="<?php echo $user_name; ?>">
                <span class="invalid-feedback"><?php echo $user_name; ?></span>
            </div>    
            <div class="form-group">
                <label>password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                 <input type="hidden" name="device_name" class="form-control"> 
             </div>
             <div class="form-group">
                 <input type="hidden" name="location" class="form-control"> 
             </div>
             <div class="form-group">
                 <input type="hidden" name="floor" class="form-control"> 
             </div>
             <div class="form-group">
                 <input type="hidden" name="longitude" class="form-control"> 
             </div>
             <div class="form-group">
                 <input type="hidden" name="latitude" class="form-control"> 
             </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Join">
            </div>
            <p>Do you want to be a user?<a href="signup.php"> Sign up</a></p>
        </form>
    </div>
</body>
</html>