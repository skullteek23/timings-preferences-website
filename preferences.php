<?php
//start session
session_start();


// Include config file
require "config.php";

//Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// require default settings for preferences
include "teams.php";
include "default.php";

// main work
if($_SERVER["REQUEST_METHOD"] === "POST"){
	
	if(($_SESSION["default"]) || ($_SESSION["default"] === true)){
		
		
		
		
		$sql2 = "UPDATE pref SET tn = ?, 7AM = ?, 8AM = ?, 9AM = ?, 10AM = ?, 11AM = ?, sn = ? WHERE username = ?";
		if($stmt2 = mysqli_prepare($con, $sql2)){
			
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt2, "siiiiiss",$_POST["tname"], $sat7, $sat8, $sat9, $sat10, $sat11,$_POST["txt"], $param_username);
            
            // Set parameters
            $param_username = $_SESSION["username"];
			 
			$sat7=$sat8=$sat9=$sat10=$sat11=0;
			if(isset($_POST["sat7"])){
				$sat7 = $_POST["sat7"];
			}
			if(isset($_POST["sat8"])){
				$sat8 = $_POST["sat8"];
			}
			if(isset($_POST["sat9"])){
				$sat9 = $_POST["sat9"];
			}
			if(isset($_POST["sat10"])){
				$sat10 = $_POST["sat10"];
			}
			if(isset($_POST["sat11"])){
				$sat11 = $_POST["sat11"];
			}
			
			
                      
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt2)){
                // preferences updated successfully. Destroy the session, and redirect to welcome page
                
				header("location: welcome.php");
                exit;
            } 
			else{
				
                echo "Oops! Something went wrong. Please try again later.";
            }
        // Close statement
        mysqli_stmt_close($stmt2);
		
		}
          
       // Close connection
       mysqli_close($con);
	   
	   
	}
	else{
		
        echo "Oops! Something went wrong. Please try again later.";
    }
	
}
	
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Freekyk poll page</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
      html, body {
      min-height: 100%;
      }
      body, input { 
      padding: 0;
	  
      margin: 0;
      outline: none;
      font-family: Roboto, Arial, sans-serif;
      font-size: 14px;
      color: #666;
      line-height: 22px;
      }
      h1, h4 {
      font-weight: 400;
      }
      h4 {
      margin: 22px 0 4px;
      }
      h5 {
      text-transform: uppercase;
      color: #095484;
      }
      .main-block {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 3px;
      }
      form {
      width: 100%;
      padding: 20px;
      box-shadow: 0 2px 5px #ccc; 
      background: #fff;
      }
      input {
      width: calc(100% - 10px);
      padding: 5px;
      border-radius: 3px;
      border: 1px solid #ccc;
      vertical-align: middle;
      }
      textarea {
      width: calc(100% - 6px);
      outline: none;
      }
      input:hover, textarea:hover {
      outline: none;
      border: 1px solid #095484;
      }
      th, td {
      width: 15%;
      padding: 15px 0;
      border-bottom: 1px solid #ccc;
      text-align: center;
      vertical-align: unset;
      line-height: 18px;
      font-weight: 400;
      word-break: break-all;
      }
      .additional-question th, .additional-question td {
      width: 38%;
      }
      .course-rate th, .course-rate td {
      width: 19%;
      }
      .first-col, .additional-question  .first-col, .course-rate .first-col {
      width: 24%;
      text-align: left;
      }
      .question, .comments {
      margin: 15px 0 5px;
      }
      .question-answer label {
      display: inline-block;
      padding: 0 20px 15px 0;
      }
      .question-answer input {
      width: auto;
      }
      .question-answer, table {
      width: 100%;
      }
      .btn-block {
      margin-top: 20px;
      text-align: center;
      }
      button {
      width: 150px;
      padding: 10px;
      border: none;
      border-radius: 5px; 
      background: #095484;
      font-size: 16px;
      color: #fff;
      cursor: pointer;
      }
      button:hover {
      background: #0666a3;
      }
      @media (min-width: 568px) {
      th, td {
      word-break: keep-all;
      }
      }
	  #demo{
      text-align: center;
      font-size: 60px;
      margin-top: 0px;
      color: green;
	  background: black;
}
    </style>
  </head>
  <body bgcolor="green">
    
	<div class="main-block">
      <form method="post" action="" >
        <h1>Freekyk MatchDay Availability</h1>
		<!-- Display the countdown timer in an element -->
        <p id="demo"></p>

<script>
// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2021 15:37:25").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
		<!-- TEAM NAME -->
		<div>
		<strong>Team Name</strong>
		<select name="tname" required>
         <?php
		 echo "<option>".$team_data["default"]["Team_Name"]."</option>";
		  foreach($team_data["team_names"] as $teams) echo "<option value='".$teams."'>".$teams."</option>"; ?>
		</select>
        </div>
        
        <h1 align="center">FILL YOUR PREFERENCES</h1>
        <div>
          
          <table>
            
			 for saturday 
			<tr>
              <th class="first-col"></th>
              <?php foreach($team_data["timings"] as $teams) echo "<th>".$teams."</th>"; ?>
            </tr>
            
			
			<tr>
              <td class="first-col">Available Kick-Off Timings (Saturday)</td>
              <?php for($i = 7;$i < 13;) echo"<td><input type='checkbox' value='1' name='sat".$i++."'></input></td>"; ?>
			</tr>
			<tr>
              <td class="first-col">Available Kick-Off Timings (Sunday)</td>
              <?php for($i = 7;$i < 13;) echo"<td><input type='checkbox' value='1' name='sun".$i++."'></input></td>"; ?>
			</tr>
          </table>
        
		</div>
        
        <p class="comments">Any Additional Requirements</p>
        <textarea rows="5" maxlength="150" name="txt" placeholder="enter additional notes here(if any)..."></textarea>
        
        <div class="btn-block">
          <button type="submit">Confirm</button>
		</div>
      </form>
    </div>
	<div align="center" style="padding-top:20px">
	   <img src="logo.png" alt="Freekyk Logo" height="250px" width="230px" >
	
	</div>
	
  </body>
</html>