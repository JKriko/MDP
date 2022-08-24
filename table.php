<?php  
session_start();
require_once 'config.php';

$user_name = $_SESSION["user_name"] ;
$device_name = $_SESSION["device_name"];
// $floor = $_SESSION["floor"];
// $location = $_SESSION["location"];
// $longitude = $_SESSION["longitude"];
// $latitude = $_SESSION["latitude"];

    $sql = "SELECT time, status FROM device  WHERE device_name ='$device_name' " ;
    $result = $link->query($sql);


  
?>




<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
@import url(https://fonts.googleapis.com/css?family=Oswald:400);

.navigation {
  width: 100%;
  background-color: black;
}

img {
  width: 25px;
  border-radius: 50px;
  float: left;
}

.logout {
  font-size: .8em;
  font-family: 'Oswald', sans-serif;
	position: relative;
  right: -18px;
  bottom: -4px;
  overflow: hidden;
  letter-spacing: 3px;
  opacity: 0;
  transition: opacity .45s;
  -webkit-transition: opacity .35s;
  
}

.button {
	text-decoration: none;
	float: right;
  padding: 12px;
  margin: 15px;
  color: white;
  width: 25px;
  background-color: black;
  transition: width .35s;
  -webkit-transition: width .35s;
  overflow: hidden
}

a:hover {
  width: 100px;
}

a:hover .logout{
  opacity: .9;
}

a {
  text-decoration: none;
}

body{ font: 14px sans-serif; text-align: center; color: black; background-image:; background-position: center; background-repeat: no-repeat; background-attachment: fixed; background-size: 1707px 837px; }
</style>
</head>
<body>
    <div class = "body"></div>
<h2>My Table</h2>

<div class="navigation">
  
	<a class="button" href="login.php">
  	<img src="./img/power.jpg">
  
  <div class="logout">LOGOUT</div>

	</a>
  
</div>

    <?php         
        echo "<table><tr><th>Status</th><th>Time</th></tr>";
        while($row = $result->fetch_assoc()){
        echo "<tr><td>".$row["status"]."</td><td>".$row["time"]."</td><td>";
        }
         
        echo "</table>";
    ?>
</table>

</body>
</html>


