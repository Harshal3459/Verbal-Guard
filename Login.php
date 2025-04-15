<?php

session_start();
if (isset($_COOKIE['message'])) {
    $ban_message = $_COOKIE['message'];
    echo "<div id='error-message' style='text-align:center;font-size:20px;color:black;'>"; 
 	echo $ban_message;
    echo "</div>";
    // Delete the cookie
    setcookie("message", "", time()-3600, "/");
}

include("classes/connect.php");
include("classes/Login.php");

$email = "";
$password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = new Login();
    $result = $login->evaluate($_POST);
    if ($result != "") {
        echo "<div id='error-message' style='text-align:center;font-size:20px;color:black;'>";
        
        echo $result;
        echo "</div>";
    } else {
        // Redirect to the home page
        header("Location: home.php");
        die;
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
}

?>

<html>
	<head>
		<title>Log in | YOUBOOK</title>
	</head>
	<style>
		#title {
			height: 75px;
			background-color: blueviolet;
			color: white;
			font-size: 40px;
			font-family: tahoma;
			letter-spacing: 3px;
			padding: 4px;
			padding-top: 25px;
			font-weight: bold;
		}
		#signup_button {
			background-color: #42b72a;
			width: 70px;
			text-align: center;
			padding: 4px;
			border-radius: 4px;
			float: left;
			color: white;
			cursor: pointer;
		}
		#back {
			background-color: white;
	   		width: 800px;
	   		height: 400px;
	   		margin:auto;
	   		margin-top: 50px;
	   		padding:10px;
	   		padding-top: 50px;
	   		text-align:center;
	   		font-weight: bold;
	   	}
	   	#text {
	   		height: 40px;
	   		width: 300px;
	   		border-radius: 4px;
	   		border:solid 1px #ccc;
	   		padding:4px;
	   		font-size: 14px;
	   	}
	   	#button {
	   		width: 300px;
	   		height: 40px;
	   		border-radius: 4px;
	   		background-color: blueviolet;
	   		color: white;
	   		border:none;
	   		font-weight: bold;
	   		font-size: 14px;
	   		cursor: pointer;

	   	}
	   	#error-message {
	        background-color: #fdd; /* Light red background */
	        color: #c00; /* Dark red text */
	        border: 2px solid #c00;
	        padding: 10px;
	        margin: 15px;
	        position: fixed; /* Position it relative to the viewport */
	        z-index: 1000;  /* Ensure it displays on top of other content */
	        position: fixed; 
	        top: 22%;
	        left: 49%;
	        transform: translate(-50%, -50%);
	        font-weight: bold;


		}
	
	</style>
	<body style="font-family: tahoma;background-color: ghostwhite;">
	   
	   <div id="title">
	   	YOUBOOK
	   </div>
	   
	   	<div id="signup_button" onclick="location.href='Signup.php'">
   			Sign up
		</div>
	
	   <div id="back">
	   	<form method="post">
		   	Log in to YOUBOOK<br><br>
		   	<input name="email" type="text" id="text" placeholder="Email" value="<?php echo $email; ?>"><br><br>
		   	<input name="password" type="password" id="text" placeholder="Password" value="<?php echo $password; ?>"><br><br>
		   	<input type="submit" id="button" value="Log in">
	    </form>
		</div>
		<script>
    setTimeout(function() {
        let errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'none'; 
        }
    }, 5000); // Adjust the timeout value (3000 means 3 seconds)
 		</script>
	</body>
</html>


