<?php
	
	include("classes/connect.php");
	include("classes/SignUp.php");
	
	$first_name = "";
	$last_name = "";
	$email = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$SignUp = new Signup();
		$result = $SignUp->evaluate($_POST);
		if($result != "")
		{
			echo "<div id='error-message' style='text-align:center;font-size:17px;color:black;'>"; 
        	echo $result;
        	echo "</div>";

			
		}
		else
		{
			header("Location:Login.php");
			die;
		}
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
	}

?>
<html>
	<head>
		<title>Sign up | YOUBOOK</title>
	</head>
	<style>
		#title
		{
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
		#signup_button{
			background-color: #42b72a;
			width: 70px;
			text-align: center;
			padding: 4px;
			border-radius: 4px;
			float: left;
			color: white;
			cursor: pointer;

		}
		#back{
			background-color: white;
	   		width: 800px;
	   		height: 400px;
	   		margin:auto;
	   		margin-top: 50px;
	   		padding:10px;
	   		padding-top: 50 ;
	   		text-align:center;
	   		font-weight: bold;
	   		}
	   	#text{
	   		height: 40px;
	   		width: 300px;
	   		border-radius: 4px ;
	   		border:solid 1px #ccc;
	   		padding:4px;
	   		font-size: 14px;

	   	}
	   	#button{
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
	   
	   	<div id="signup_button" onclick="location.href='Login.php'">
	   	Log in
	   	</div>
	   
	   <div id="back">
	   	Sign up to YOUBOOK<br><br>

	   	<form method="post" action="">
	   	
	   	<input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="Enter First Name" ><br><br>
	   	<input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Enter Last Name" ><br><br>
	   	<input value="<?php echo $email ?>" name="email" type="text" id="text" placeholder="Enter Email" ><br><br>
	   	<input name="password" type="password" id="text" placeholder="Create Password"><br><br>
	   	<input name="password2" type="password" id="text" placeholder="Confirm Password"><br><br>
	   	<input type="submit" id="button" value="Sign up">
		
		</form>

		</div>
		<script>
    setTimeout(function() {
        let errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'none'; 
        }
    }, 4000); // Adjust the timeout value (3000 means 3 seconds)
 		</script>

	


	</body>





</html>