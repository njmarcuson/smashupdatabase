<?php
/*
This class stores some vital information about a User
Particularly, their email and expansions
*/
class User {

    // check if the user even exists
    public function __construct(
        private string $email,
        private string $password,
        protected $conn
    ) {
        $prep = "SELECT COUNT(*) 
                 FROM users
                 WHERE email = ?
                    AND password = ?";
        $stmt = $conn->prepare($prep);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);
        $count = $row["COUNT(*)"];
        if ($count != 1) {
            throw new Exception('the email password combo does not match');
        }
    }

    public function get_email() {
        return $this->email;
    }

    public function get_password() {
        return $this->password;
    }
}
?>