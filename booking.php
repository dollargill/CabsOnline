<head>

  <title>Booking</title> 
  <link rel="stylesheet" type="text/css" href="bookingstyle.css">
</head> 
  <body>
  <div class="page-background">
    <div class="blob top-right"></div>
    <div class="blob bottom-left"></div>
    <div class="login-container">
  <H1>Booking a cab</H1>

  <form action ="booking.php" method="post">

<p>Please fill the fields below to book a taxi.</p>
  <table>
<tr>
	   <td><label>Passenger name:</label></td> <td><input type="text" name="passName" maxlength="30"></td>
</tr><tr>
 	   <td><label>Contact phone:</label></td> <td><input type="text" name="phoneNo" maxlength="12"></td>
</tr><tr>
	   <td><label>Pick up address:</label></td> <td><label>Unit number </label><input type="text" name="unitNo" maxlength="4"></td>
</tr><tr>
		<td></td><td><label>Street number</label> <input type="text" name="streetNo" maxlength="4"></td>
</tr><tr>
		<td></td><td><label>Street name</label><input type="text" name="streetName" maxlength="20"></td>
</tr><tr>
		<td></td><td><label>Suburb name</label><input type="text" name="suburb" maxlength="20"></td>
</tr><tr>
	   <td><label>Destination suburb name:</label></td> <td><input type="text" name="destination" maxlength="20"></td>
</tr><tr>
	   <td><label>Pickup date (yyyy-mm-dd):</label></td> 
	   <td><div class="well">
			  <div id="datetimepicker4" class="input-append">
			    <input data-format="yyyy-MM-dd" type="text" name ="pDate"></input>
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
			    </span>
			  </div>
			</div>
</td>
</tr><tr>
	   <td><label>Pickup time (hh:mm)24-hour clock:</label></td>
	   		  <td><div class="well">
			  <div id="datetimepicker3" class="input-append">
			    <input data-format="hh:mm:ss"  type="text" name ="pTime"></input>
			    <span class="add-on">
			      <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
			    </span>
			  </div>
			</div>
</td>
</tr><tr>
	   <td></td><td><button type="reset" value="Reset">Reset</button><button type="submit" name="submit">Submit</button></td>
</tr>
  </table>
  </form>
   <a href="logout.php">Log Out</a>
  <br>
  <br>
    <script type="text/javascript"
     src="js/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="js/bootstrap-datetimepicker.pt-BR.js">
    </script>
  			<script type="text/javascript">
			  $(function() {
			    $('#datetimepicker4').datetimepicker({
			      pickTime: false
			    });
			  });
			</script>
			<script type="text/javascript">
			  $(function() {
			    $('#datetimepicker3').datetimepicker({
			      pickDate: false
			    });
			  });
			</script>
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
	$passName = $_POST['passName'];
	$passPhone = $_POST['phoneNo'];
	$unitNo = $_POST['unitNo'];
	$streetNo = $_POST['streetNo'];
	$streetName = $_POST['streetName'];
	$suburb = $_POST['suburb'];
	$destination = $_POST['destination'];
	$pDate = $_POST['pDate'];
	$pTime = $_POST['pTime'];
	$count = 0 ;

//validate the passenager name
	if (empty($passName)) {
	echo "Please enter passenager name.<br>";
   	} else {
	$passName = $_POST['passName'];
	++$count;
	}
//validate phone number of passenger
	if (empty($passPhone)) {
	echo "Please enter contact phone number.<br>";
   	} elseif (is_numeric($_POST['phoneNo'])) {
	$passPhone = $_POST['phoneNo'];
	++$count;
	} else { 
	echo "Please enter a valid contact number.<br>";
	}
//validate unit number (not required here)

//validate street number	
	if (empty($streetNo)) {
	echo "Please enter street number.<br>";
	} elseif (is_numeric($_POST['streetNo'])) {
 	$streetNo = $_POST['streetNo'];
	++$count;
	} else { 
	echo "Please enter a valid street number.<br>";
	}
//validate street name
	if (empty($streetName)) {
	echo "Please enter street name.<br>";
	} else {
	$streetName = $_POST['streetName'];
	++$count;
	}
//validate suburb name
	if (empty($suburb)) {
	echo "Please enter suburb name.<br>";
   	} else {
	$suburb = $_POST['suburb'];
	++$count;
	}
//validate destination suburb name
	if (empty($destination)) {
	echo "Please enter destination suburb name.<br>";
   	} else {
	$destination = $_POST['destination'];
	++$count;
	}

// format the pickup date and time
	date_default_timezone_set('UTC');
	$today = time()+46800; /// + 13 hours adjustment for New Zealand Timezone
	$pDateTime = strtotime("$pDate $pTime");

//validate pickup date & time 
if (empty($pTime) or empty($pDate)) {echo "Please input the pick up date and time.<br>";}
elseif ($pDate && $pTime) {
 	$diff = ($pDateTime - $today)/3600; // calculate the difference in hours

			if ($diff >= 0.9) { 
			++$count;
			$pDateTime = date('Y-m-d H:i:s', strtotime("$pDate $pTime"));
			} else {
			echo "The pickup time needs to be set at least 1 hour after the current time. Please adjust accordingly.<br>";
			} 
} else {
echo "Please enter a valid pickup date & time.<br>";
}
	
//retrieve session data
 	session_start();
	if (isset($_SESSION['useremail'])) {
	 $email = $_SESSION['useremail'];

//write to database of booking table
if ($count == 7) {
$query = "INSERT INTO booking (email, passName, passPhone, unitNo, streetNo, streetName, suburb, destination, PickupDateTime, SystemStatus) 
VALUES ('$email', '$passName','$passPhone','$unitNo','$streetNo', '$streetName', '$suburb', '$destination', '$pDateTime', 'unassigned')";
$queryResult = @mysqli_query($DBConnect, $query)
Or die ("<p>1.Unable to query the table.</p>"."<p>Error code ".mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
				
	if (mysqli_affected_rows($DBConnect) == 1) {
	// get data from database for reply message
	$refNo = "SELECT bookingNo from booking where  email = '$email' order by SysDateTime desc limit 1 ";
	$query = @mysqli_query($DBConnect,$refNo) Or die ("<p>2.Unable to query the table.</p>"."<p>Error code ".mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
	$msg = mysqli_fetch_row($query); 
		
	$pickDate = date('Y-m-d', strtotime($pDate));
	$pickTime = date('H:i', strtotime($pTime));
	$reply = "Your booking reference number is ".$msg[0].". We will pick up the
	passengers from the provided address at ".$pickTime." on ".$pickDate."."; 
	echo "Thank you! ".$reply; //comfirm the booking is success
	sleep(3);
	mysqli_close($DBConnect);
	
//Sending confirmation email
$to = $email;
$subject ="Your booking request with CabsOnline";
$message = "Dear ".$passName." ,Thanks for booking with CabsOnline! ".$reply;
$header = "From: dollargill.au@gmail.com";
mail($to, $subject, $message, $header);
session_write_close();

		} else {
		echo "A system error may have occurred. We kindly ask you to book your taxi directly by calling us. We apologize for any inconvenience this may have caused."; //No booking info taken fm sql
		exit;
		}
	} 
	}  else {
		echo "We are sorry, but we could not find your information. Please <a href='login.php'>Log In</a> here."; 
	}// end of session
}
?>
