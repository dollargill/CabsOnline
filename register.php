  <head> 
  <link rel="stylesheet" type="text/css" href="loginstyle.css">
  <title>Registration</title> 
  </head> 
  <body>
  <div class="page-background">
    <div class="blob top-right"></div>
    <div class="blob bottom-left"></div>
    <div class="login-container">
  <H1>Register to CabsOnline</H1>
  <form action ="register.php" method="post">
  <p>Please provide information in the fields below to complete your registration.</p> 
   <table>
<tr>
	   <td><label>Name:</label></td> <td><input type="text" name="name" maxlength="30"></td>
</tr><tr>
 	   <td><label>Password:</label></td> <td><input type="text" name="pwd"  maxlength="30"></td>
</tr><tr>
	   <td><label>Confirm password:</label></td> <td><input type="text" name="Cpwd"  maxlength="30"></td>
</tr><tr>
	   <td><label>Email:</label></td> <td><input type="text"   name="email"  maxlength="30"></td>
</tr><tr>
	   <td><label>Phone:</label></td> <td><input type="text"   name="phone" maxlength="12"><br></td>
</tr><tr>
	   <td></td><td><button type="reset" value="Reset">Reset</button><button type="submit" name="submit">Submit</button></td>
</tr>
  </table>
  </form>
  <b>Already registered? </b>  <a href="login.php">Login here</a><br><br>
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

//get name, password, e-mail and contact number passed from client
if (isset($_POST['submit'])) 
	{
	$name = $_POST['name'];
	$pwd = $_POST['pwd'];
	$Cpwd = $_POST['Cpwd'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$count = 0;

//validate the name
	if (empty($name)) {
	echo "Please enter your name.<br>";
   	} else {
	$name = $_POST['name'];
	++$count;
	}

//validate password
	if (empty($pwd)) {
	echo "Please enter your password.<br>";
   	} elseif (empty($Cpwd)) {
	echo "Please enter a confirmation password.<br>";
	} elseif ($pwd !== $Cpwd) {
	echo "The passwords does not match. Please enter again.<br>";
	} else {
		$pwd = $_POST['Cpwd'];
		++$count;
	}

//validate email
	if (empty($email)) {
	echo "Please enter a valid e-mail address.<br>";
	} elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == true)   {
		//access data in database
		$SQLstring = "SELECT Email from customer where Email = '$email';";
		$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>1.Unable to query the table.</p>"."<p>Error code ".mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";		
		if (mysqli_num_rows($queryResult) !== 0)
				{ --$count;
				echo "This email is already registered with us. Please use another email address. Thank You!<br>";
				} else {
				$email=strtolower($_POST['email']);
				++$count;
				}
	} else { 
	echo "Please enter a valid e-mail address.<br>";
	}
	
//validate phone
	if (empty($phone)) {
	echo "Please enter your contact phone number.<br>";
   	} elseif (is_numeric($phone)) {
	$phone = $_POST['phone'];
	++$count;
	} else { 
	echo "Please enter a valid contact number.<br>";
	}

//write to database of customer table
if ($count == 4) {
$query = "INSERT INTO customer ( Name, Password, Email, Phone) VALUES  ('$name','$pwd','$email','$phone');";
$result= @mysqli_query($DBConnect,$query)
Or die ("<p>2.Unable to query the table.</p>"."<p>Error code ".mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect). "</p>");
				}
	if (mysqli_affected_rows($DBConnect) == 1) {
          echo "Thank you. You are successfully registered. You may now <a href='login.php'>Log In</a> here."; 
         }
    mysqli_close($DBConnect);
}
?>
