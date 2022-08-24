<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$user_name = $location = $device_name = $password = $floor = $longitude = $latitude =  "";
$user_name_err = $location_err  = $device_name_err = $password_err = $floor_err = $longitude_err = $latitude_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate client username
    if(empty(trim($_POST["user_name"]))){
        $user_name_err = "Please enter client username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["user_name"]))){
        $user_name_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM data WHERE user_name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_user_name);
            
            // Set parameters
            $param_user_name = trim($_POST["user_name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $user_name_err = "This username is already taken.";
                } else{
                    $user_name = trim($_POST["user_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate client location
    if(empty(trim($_POST["location"]))){
        $location_err = "Please enter client location.";     
    } else{
        $location = trim($_POST["location"]);
    }

    // Validate client floor
    if(empty(trim($_POST["floor"]))){
        $floor_err = "Please enter client floor.";     
    } else{
        $floor = trim($_POST["floor"]);
    }

    // Validate client longitude
    if(empty(trim($_POST["longitude"]))){
        $longitude_err = "Please enter client longitude.";     
    } else{
        $longitude = trim($_POST["longitude"]);
    }

    // Validate client latitude
    if(empty(trim($_POST["latitude"]))){
        $latitude_err = "Please enter client latitude.";     
    } else{
        $latitude = trim($_POST["latitude"]);
    }

    // Validate device_name
    if(empty(trim($_POST["device_name"]))){
        $device_name_err = "Please enter device name.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM data WHERE device_name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_device_name);
            
            // Set parameters
            $param_device_name = trim($_POST["device_name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $device_name_err = "This device name is already taken.";
                } else{
                    $device_name = trim($_POST["device_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Check input errors before inserting in database
    if(empty($user_name_err) && empty($device_name_err) && empty($password_err) && empty($longitude_err) && empty($latitude_err) && empty($floor_err) && empty($location_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO data (user_name, location, floor, longitude, latitude, device_name, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_user_name, $param_location, $param_floor, $param_longitude, $param_latitude, $param_device_name, $param_password);
            
            // Set parameters
            $param_user_name = $user_name;
            $param_location = $location;
            $param_device_name = $device_name;
            $param_floor = $floor;
            $param_latitude = $latitude;
            $param_longitude = $longitude;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: success.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; color: black; background-image: url(https://epd.eu/wp-content/uploads/2020/07/AdobeStock_204993923-1024x630.jpeg); background-position: center; background-repeat: no-repeat; background-attachment: fixed; background-size: 1707px 837px; }
        .wrapper{ position: fixed; width: 360px; height: 720x; margin: 3.5% auto; left: 0; right: 0; border-style: solid; padding: 10px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign up for National Power Meter</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Client Username</label>
                <input type="text" name="user_name" class="form-control <?php echo (!empty($user_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $user_name; ?>">
                <span class="invalid-feedback"><?php echo $user_name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Client Location</label>
                <input type="location" name="location" class="form-control <?php echo (!empty($location_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $location; ?>">
                <span class="invalid-feedback"><?php echo $location_err; ?></span>
            </div>
            <div class="form-group">
                <label>Client Floor</label>
                <input type="floor" name="floor" class="form-control <?php echo (!empty($floor_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $floor; ?>">
                <span class="invalid-feedback"><?php echo $floor_err; ?></span>
            </div>
            <div class="form-group">
                <label>Client longitude</label>
                <input type="longitude" name="longitude" class="form-control <?php echo (!empty($longitude_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $longitude; ?>">
                <span class="invalid-feedback"><?php echo $longitude_err; ?></span>
            </div>
            <div class="form-group">
                <label>Client latitude</label>
                <input type="latitude" name="latitude" class="form-control <?php echo (!empty($latitude_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $latitude; ?>">
                <span class="invalid-feedback"><?php echo $latitude_err; ?></span>
            </div>
            <div class="form-group">
                <label>Device Name</label>
                <input type="device_name" name="device_name" class="form-control <?php echo (!empty($device_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $device_name; ?>">
                <span class="invalid-feedback"><?php echo $device_name_err; ?></span>
            </div>      
            <div class="form-group">
                <label>password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>