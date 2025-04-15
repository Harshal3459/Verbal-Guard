<?php

class Post
{
    private $error = ""; // Initialize error message

    public function create_post($userid, $data, $DB)
{
        $api_url = "http://127.0.0.1:5000/detect_hate_speech";

        if (!empty($data['post'])) {
            $post = addslashes($data['post']); 

            // **** HTTP Request to Your API ****

            $data = array('comment' => $post);
            $data_json = json_encode($data);

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo "API request error: " . curl_error($ch);
            } else { 
                $result = json_decode($response, true); 
                if ($result === null) { 
                    echo "Error decoding JSON response";
                } else {
                    $is_hate_speech = $result['hate_speech']; 

                    // **** Hate Speech Logic with Strike Tracking ****
                    if ($is_hate_speech) {

                        // Update hate_speech_strikes
                        $query = "UPDATE users SET hate_speech_strikes = hate_speech_strikes + 1 WHERE userid = $userid LIMIT 1";
                        $DB->save($query); 

                        // Check for 3 strikes and delete the account
                        $query = "SELECT hate_speech_strikes FROM users WHERE userid = $userid LIMIT 1";
                        $result = $DB->read($query); 

                        if ($result) {
                            $row = $result[0]; 
                            $remaining_attempts = 3 - $row['hate_speech_strikes'];

                            if ($row['hate_speech_strikes'] >= 3) {
                                $this->delete_user($userid, $DB); 
                                session_destroy(); 
                                header("Location: login.php");
                            } else {
                                return "Your post contains hate speech and cannot be posted. You have " . $remaining_attempts . " attempt(s) left before your account will be deleted.";
                            }
                        } else { 
                            echo "Error fetching user data: " . $DB->error; 
                        }
                    } 
                    else {
                        $postid = $this->create_postid();
                        $query = "INSERT INTO posts (userid, postid, post) VALUES ('$userid', '$postid', '$post')";
                        $DB = new Database();
                        $DB->save($query);
                        header("Location: home.php");
                        die;
                    }
                }
            }
            curl_close($ch);
        } else {
            $this->error .= "Please type something to post!<br>";
        }

        return $this->error;
}


    private function delete_user($userid, $DB) 
    { // Accept the $DB object 
        // 1. Delete all posts made by this user 
        $query = "DELETE FROM posts WHERE userid = $userid";
        $DB->save($query); // Use the passed $DB object

        // 2. Delete the user from the 'users' table
        $query = "DELETE FROM users WHERE userid = $userid LIMIT 1";
        $DB->save($query);
        setcookie("message", "Your account has been banned due to violation of our community guidelines.", time()+3600, "/");
        session_destroy();
        header("Location: login.php");
        
    }

    public function get_posts()
    {
        $query = "SELECT * FROM posts order by id desc limit 10";
        $DB = new Database();
        $result = $DB->read($query);
        if($result)
        {
            return $result;
        }
        else
        {
            return false;
        }
    }

    private function create_postid()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i = 1; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
        return $number;
    }
}


