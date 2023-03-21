<?php
$errors = '';
// Passing values from our HTML page
$movie = $_COOKIE['movie'];
$name = $_POST['name'];
$dateTime = $_POST['dateTime'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$spam = $_POST['spamTrap'];

echo '<body style="background-color:#000000;">';
// Spam trap if/else condition 
if ($spam) {
	die("Spam free zone!");
} else {
	$to_email = $email;
	$subject = "Ticket booking confirmation.";
	$body = "Hi $name, This is to confirm that your $movie tickets have been booked for $dateTime. Hope you enjoy the movie!!";
	$headers = "From: CCT Movie House";
	// Confirmation email sent to customer on successful booking with accurate email
	// Message displayed on submission accordingly
	if (mail($to_email, $subject, $body, $headers)) {
		echo nl2br("<p style='color:#14ebff;' style='font-size:2vw;'>Confirmation email successfully sent to $to_email.</p>");
	} else {
		echo nl2br("<p style='color:#14ebff;' style='font-size:2vw;'>Email could not be sent to $to_email! \nPlease try again.</p>");
	}
}

if (empty($errors)) {
	// Accessing our Database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "test";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// Adding data to our table
	$sql = "INSERT INTO movie_bookings (movie, name, dateTime, email, phone)
	VALUES ('$movie','$name','$dateTime','$email','$phone')";

	if ($conn->query($sql) === TRUE) { // message on succesfull submission
		echo nl2br("<p style='color:#ff00ea;' style='font-size:2vw;'>\n New record created successfully</p>");
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	echo nl2br("<p style='color:#14ebff;' style='font-size:2vw;'>\n $movie Booking details stored.</p>");
	header("refresh:10;url=http://localhost/CA1%20Assignement/index.html?");
	$conn->close();
}
