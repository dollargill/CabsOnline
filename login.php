<head> 
<link rel="stylesheet" type="text/css" href="loginstyle.css">
  <title>Login</title> 
  </head>
  <body>
  <div class="page-background">
    <div class="blob top-right"></div>
    <div class="blob bottom-left"></div>
    <div class="login-container">
        <h1>Login to CabsOnline</h1>
        <form method="post" action="login.php">
            <table>
                <tr>
                    <td><label>Email:</label></td>
                    <td><input type="text" name="email" maxlength="30"></td>
                </tr>
                <tr>
                    <td><label>Password:</label></td>
                    <td><input type="password" name="pwd" maxlength="30"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="reset" value="Reset" class="button-spacing">Reset</button>
                        <button type="submit" name="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
        <div class="register-link"><b>New Member?</b> <a href="register.php">Register now</a></div>
    
<footer>	
  <hr>
  <p>Author: Dollar Karan Preet Singh Student ID: 104086732 Version: 1.0 Date: 10 March 2024</p>
  <p>Designed and Developed with ❤️ by Dollar Karan Preet Singh. <br>&copy; 2024 Dollar Karan Preet Singh. All rights reserved.</p>
</footer>
</div>
</div>
</body>


<?php 
 //connect to mysql server
include ('dbconnect.php');

//get password and e-mail passed from client
if (isset($_POST['submit'])) 
	{
	$email = strtolower($_POST['email']);	
	$pwd = $_POST['pwd'];

//check whether the user input the password and email
	if (empty($pwd) or empty($email)) {
	echo "Please enter your email and password.<br>";
   	} 
//validate email
   	elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == true && $pwd) {
	//access date to database and search by email
	$SQLstring = "SELECT * from customer where Email = '$email'";
	$queryResult = @mysqli_query($DBConnect, $SQLstring)
	Or die ("<p>Unable to query the table.</p>"."<p>Error code ".
	mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
			$row= mysqli_fetch_row($queryResult);
			if ($email !== $row[2]) { // check email whether the member is exist
			echo "The member is not existed. Please register.<br>";
			}
			elseif ($pwd == $row[1]) { //check whether the password is matched 
				 	if ($row[5]=="admin") { //check if the role is admin
				 	echo "You have successfully logged in. You will be directed to the administration page shortly."; 
					sleep(3);
		//store session data
					ob_start();
					session_start();
					//session_register('useremail'); //outdated
					$_SESSION ['useremail'] =  $email;
					session_write_close();	

					$URL="admin.php";  
					header ("Location: $URL"); 
					exit; 
				 	} else {
					echo "You have successfully logged in. You will be directed to the booking page shortly."; 
					sleep(3);
		//store session data
					ob_start();
					session_start();
					//session_register('useremail'); //outdated
					$_SESSION ['useremail'] =  $email;
					session_write_close();	

					$URL="booking.php";  
					header ("Location: $URL"); 
					exit; 
					}
			} else {
			echo "The password is incorrect. Please try again.<br>";
		}
	} else { echo "Please enter a valid email and try again.<br>";}
	mysqli_close($DBConnect);	
}
?>

