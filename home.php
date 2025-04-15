<?php
session_start();

include("classes/connect.php");
include("classes/Login.php");
include("classes/User.php"); 
include("classes/post.php");

if (isset($_SESSION['YOUBOOK_userid']) && is_numeric($_SESSION['YOUBOOK_userid'])) {
    $id = $_SESSION['YOUBOOK_userid'];
    $login = new Login();
    $result = $login->check_login($id);

    if ($result) {
        $user = new User(); // Instantiate the User class
        $user_data = $user->get_data($id);

        if (!$user_data) {
            header("Location: login.php");
            die;
        } 
    } else {
        header("Location: Login.php");
        die;
    }
} else {
    header("Location: Login.php");
    die;
}

//posting starts here

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $post = new Post();
    $id = $_SESSION['YOUBOOK_userid'];
    $DB = new Database(); // Create DB object  
    $result = $post->create_post($id, $_POST, $DB);  // Pass to function

    if($result !== "")  
    { 
        echo "<div id='error-message' style='text-align:center;font-size:17px;color:black;'>"; 
        echo $result;
        echo "</div>";
    } 
        
 
}

//collect posts

	$post = new Post();
	
	$posts = $post->get_posts();


?>





<!DOCTYPE html>
<html>
<head>
    <title>Home | YOUBOOK</title>
</head>
<style type="text/css">
    #top_bar {
        height: 50px;
        background-color: blueviolet;
        color: white;
        font-size: 40px;
        font-family: tahoma;
        letter-spacing: 3px;
        padding: 4px;
        padding-left: 30px;
        font-weight: bold;
    }
    #comment_box {
        height: 50px;
        width: 500px;
        border-radius: 4px;
        border: solid 1px #ccc;
        padding: 4px;
        font-size: 14px;
        font-family: Arial;
        margin: 0 auto; /* This will center the text area */

    }
    #comment_box_back {
        background-color: white;
        width: 800px;
        height: 200px;
        margin: auto;
        margin-top: 50px;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        display: flex; /* Enable flexbox */
        justify-content: center; /* Center elements horizontally */
        align-items: center; /* Center elements vertically */
    }
        
    #post_back {
        background-color: white;
        width: 800px;
        margin: auto;
        margin-top: 20px;
        padding: 10px;
        text-align: center;
        display: flex; /* Center vertically */
        flex-direction: column; /* Stack items vertically */
        align-items: center; /* Center horizontally */
        border-radius: 4px; /* Add rounded corners */
        overflow: hidden; /* Hide overflowing content */
    }
    #posts {
        background-color: white;
        width: 700px;
        height: 300px;
        margin: auto;
        margin-top: 10px;
        padding: 10px;
        text-align: center;
        }  
       
    #button {
        width: 60px;
        height: 30px;
        border-radius: 4px;
        background-color: blueviolet;
        color: white;
        border: none;
        font-weight: bold;
        font-size: 14px;
        margin: 10px auto; /* Adjusted margin, also centers the button */
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
        top: 40%;
        left: 49%;
        transform: translate(-50%, -50%);
        font-weight: bold;
    }

    
</style>
<body style="font-family: tahoma; background-color: ghostwhite;">

<!--top bar-->
<div id="top_bar">
    <div style="margin: auto; font-size: 30px; padding-left: 320px; padding-top: 5px;">
        YOUBOOK
        <div style="margin: auto; font-size: 25px; float: right; padding-right: 30px; padding-top: 3px; letter-spacing: 0px; font-weight: normal; font-family: cursive;">
            <?php echo htmlspecialchars($user_data['first_name'] . " " . $user_data['last_name']); ?>
        </div>
        <img src="profile pic new.png" style="width: 40px; float: right; padding-right: 7px;">
        <a href="Logout.php">
            <span style="font-weight: normal; font-size: 20px; letter-spacing: 0px; font-family: Arial; float: right; padding-right: 15px; padding-top: 7px; color: white;">Log out</span>
        </a>
    </div>
</div>

<!--cover area-->
<div id="comment_box_back">
    <br><br>
    <form method="post">
        Something on your mind?<br><br>
        <textarea name="post" id="comment_box" placeholder="Share your Post!"></textarea>
        <input type="submit" id="button" value="Post">
    </form>
</div>

	<div id="post_back">

		<?php
			if(!empty($posts))
			{
				foreach ($posts as $ROW) 
                {
				    $user = new User();
                    $ROW_USER = $user->get_user($ROW['userid']);	
					include("post.php");
				
				}
			}
			
			

		?>

		
	</div>
 <script>
    setTimeout(function() {
        let errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'none'; 
        }
    }, 5000); // Adjust the timeout value (3000 means 3 seconds)
 </script>
 <script>
setInterval(function() {
    // AJAX call to check session status
    fetch('check_session.php') 
        .then(response => response.json())
        .then(data => {
            if (!data.isLoggedIn) {
                window.location.href = 'login.php'; // Redirect to login 
            }
        }); 
}, 2000); // Check every 5 seconds (adjust interval as needed)
</script>
   

</body>
</html>
