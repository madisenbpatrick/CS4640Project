<?php

class UvaMoves{
    private $command;
    
    private $db;

    public function __construct($command)
    {
        $this->command = $command;

        $this->db = new Database();
        
    }

    public function run(){
        switch($this->command){
            case "login":
                $this-> login();
                break;
            case "homepage":
                $this->homepage();
                break;
            case "activities":
                $this->activities();
                break;
            case "profile":
                $this->profile();
                break;
            case "restaurant":
                $this->restaurant();
                break;
            case "review":
                $this->review();
                break;
            case "what":
                $this->what();
                break;
            // default: 
            //     $this->homepage();
        }
    }

    private function login(){
        if (isset($_POST["email"])) {

            $data = $this->db->query("select * from uvaMoves_users where email = ?;", "s", $_POST["email"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    setcookie("name", $data[0]["name"], time() + 3600);
                    setcookie("email", $data[0]["email"], time() + 3600);
                    setcookie("id",$data[0]["id"],time()+3600);
                    
                    $user = [
                        "name" => $_COOKIE["name"],
                        "email" => $_COOKIE["email"],
                        "id" => $_COOKIE["id"],
                    ];

                    $_SESSION['name'] = $data[0]["name"];
                    $_SESSION['email'] = $data[0]["email"];
                    $_SESSION['id'] = $data[0]["id"];

                    header("Location: ?command=review");
                } else {
                    $error_msg = "Wrong password";
                }
            } else { // empty, no user found
                $insert = $this->db->query("insert into uvaMoves_users (name, email, password) values (?, ?, ?);", 
                        "sss", $_POST["name"], $_POST["email"], 
                        password_hash($_POST["password"], PASSWORD_DEFAULT));
                $data2 = $this->db->query("select * from uvaMoves_users where email = ?;", "s", $_POST["email"]);
                if ($insert === false) {
                    $error_msg = "Error inserting user";
                } else {
                    setcookie("name", $_POST["name"], time() + 3600);
                    setcookie("email", $_POST["email"], time() + 3600);
                    setcookie("id",$data2[0]["id"],time()+3600);
                    $_SESSION['name'] = $_POST["name"];
                    $_SESSION['email'] = $_POST["email"];
                    $_SESSION['id'] = $data2[0]["id"];
                    header("Location: ?command=review");
                }
            }
        }

        include("templates/login.php");

    }

    private function homepage(){
        include("templates/homepage.php");

    }

    private function activities(){
        include("templates/activities.php");
    }

    private function profile(){
        include("templates/profile.php");
    }

    private function restaurant(){
        
        include("templates/restaurant.php");
    }

    private function review(){
        include("templates/review.php");
    }

    private function what(){
        include("templates/what.php");
    }


}