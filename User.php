<?php
class User {
    private $userId=0;
    private $username;
    private $roleId=2;
    private $password;
    private $lastname;
    private $firstname;
    private $alias;
    private $email;
    private $phone;
    private $postalCode;
    private $dob;
    private $gender=0;
    private $height;
    private $weight;

    private $agent = "IE";

    public function __construct($args = null) {
        if ($args != null) {
            $this->setUser($args);
        }
    }
    public function setUser($args) {
        try {
            $this->userId = $args['user_id'];
            $this->username = $args['username'];
            $this->lastname = $args['lastname'];
            $this->firstname = $args['firstname'];
            $this->email = $args['email'];
            $this->phone = $args['phone'];
            $this->postalCode = $args['postalCode'];
            $this->dob = $args['dob'];
            $this->gender = $args['gender'];
            $this->weight = $args['weight'];
            $this->height = $args['height'];
            $this->alias = $args['alias'];
            $this->roleId = 2;//$args['roleId'];
            $this->agent = $_SERVER['HTTP_USER_AGENT'];
        } catch (PDOException $ex) {
            echo "Error: $ex";
        }
    }
    public function json() {
        return "{id:$this->userId,userId:$this->userId,username:'$this->username',lastname:'$this->lastname',firstname:'$this->firstname'," .
                "dob:'$this->dob',gender:$this->gender,height:'$this->height',weight:'$this->weight',alias:'$this->alias',"
                . "email:'$this->email',phone:'$this->phone',postalCode:'$this->postalCode',roleId:'$this->roleId',agent:'$this->agent'}";
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getRoleId() {
        return $this->roleId;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getAlias() {
        return $this->alias;
    }
    public function getPassword() {
        return $this->password;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getFirstname() {
        return $this->firstname;
    }
    public function getFullname() {
        return $this->firstname." ".$this->lastname;
    }
    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }
    public function getPostalCode() {
        return $this->postalCode;
    }

    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getAgent() {
        return $this->agent;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setAgent($agent) {
        $this->agent = $agent;
    }
    public function setAlias($alias) {
        $this->alias = $alias;
    }
    public function getContactName() {
        return "$this->firstname $this->lastname";
    }

}
?>