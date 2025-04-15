<?php
class Signup
{
    private $error = "";

    public function evaluate($data)
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->error .= "$key is empty!<br>";
            }

            if ($key == "email") {
                if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
                    $this->error .= "Invalid email address!<br>";
                }
                if ($this->email_exists($value))
                {
                    $this->error .= "This email is already registered!<br>";
                } 
                    

            }

            if (in_array($key, ["first_name", "last_name"])) {
                if (is_numeric($value)) {
                    $this->error .= "$key cannot be numbers!<br>";
                }
                if (strstr($value, " ")) {
                    $this->error .= "$key cannot have spaces!<br>";
                }
            }
        }

        if (empty($this->error)) {
            // No error, create the user
            $this->create_user($data);
        } else {
            return $this->error;
        }
    }

    public function create_user($data)
    {
        $first_name = ucfirst($data['first_name']);
        $last_name = ucfirst($data['last_name']);
        $email = $data['email'];
        $password = $data['password']; // User-entered password

        // Hash the password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $url_address = strtolower($first_name) . "." . strtolower($last_name);
        $userid = $this->create_userid();

        $query = "INSERT INTO users (userid, first_name, last_name, email, password, url_address)
                  VALUES ('$userid', '$first_name', '$last_name', '$email', '$hashed_password', '$url_address')";
        $DB = new Database();
        $DB->save($query);
    }

    private function email_exists($email)
    {
        $DB = new Database();
        $data = $DB->read("SELECT id FROM users WHERE email = '$email' LIMIT 1");
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    private function create_userid()
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

?>

