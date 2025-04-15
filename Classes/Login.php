<?php
class Login
{
    private $error = "";

    public function evaluate($data)
    {
        $email = addslashes($data['email']);
        $password = addslashes($data['password']);

        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            $row = $result[0];
            if (password_verify($password, $row['password'])) {
                $_SESSION['YOUBOOK_userid'] = $row['userid'];
            } else {
                $this->error .= "Oops wrong password!";
            }
        } else {
            $this->error .= "No such email was found!";
        }

        return $this->error;
    }

    private function hash_text($text)
    {
        return password_hash($text, PASSWORD_DEFAULT);
    }

    public function check_login($id)
    {
        $query = "SELECT userid FROM users WHERE userid = '$id' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);
        return (bool) $result;
    }
}
?>
