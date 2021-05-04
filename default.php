<?php

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || ($_SESSION["loggedin"] !== true)){
    header("location: login.php");
    exit;
}
$_SESSION["default"] = 0;
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$query = "SELECT * FROM pref WHERE username = ?";
	if($stmt = mysqli_prepare($con, $query)){
        
		// Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
            
        // Set parameters
        $param_username = $_SESSION["username"];
            
        // Attempt to execute the prepared statement
       if(mysqli_stmt_execute($stmt)){
        
		   /* store result */
           mysqli_stmt_store_result($stmt);
           if(mysqli_stmt_num_rows($stmt) == 1){
               $_SESSION["default"] = 1;
			 
            } 
		   else{
               
			   $query2 = "INSERT INTO pref (username, 7AM, 8AM, 9AM, 10AM, 11AM) VALUES (?, ?, ?, ?, ?, ?)";
		  	   $stmt2 = mysqli_prepare($con, $query2);
			   // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt2, "siiiii", $param_username2, $sat7, $sat8, $sat9, $sat10, $sat11);
			 
			   // Set parameters
               $param_username2 = $_SESSION["username"];
			   $sat7=$sat8=$sat9=$sat10=$sat11=0;
            
               // Attempt to execute the prepared statement
               if(mysqli_stmt_execute($stmt2)){
				   $_SESSION["default"] = 1;
			   }
			   else{
			  	   die("Oops! Something went wrong. Please try again later.");
			   }
         
		    }
        
		 // Close statement
         mysqli_stmt_close($stmt);
		
		}  
	   else{
            die("Oops! Something went wrong. Please try again later.");
       }
    }
}

?>