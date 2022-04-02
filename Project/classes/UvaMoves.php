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
            case "logout":
                $this->destroyCookies();
            case "homepage":
                $this->homepage();
                break;
            case "activities":
                $this->activities();
                break;
            case "profile":
                $this->profile();
                break;
            case "yourReviews":
                $this->yourReviews();
                break;
            case "yourFavorites":
                $this->yourFavorites();
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
        if (!isset($_COOKIE["email"])) {
            // they need to see the login
            $command = "login";
        }
        else {
            // if login go straight to review page 
            header("Location: ?command=review");
        }
        if (isset($_POST["email"]) && ($_POST["email"] != "") && $_POST["password"] != "") {

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
    private function destroyCookies() {          
        setcookie("name", "", time() - 3600);
        unset($_SESSION['name']);
        setcookie("email", "", time() - 3600);
        unset($_SESSION['email']);
        setcookie("id",0,time()-3600);
        unset($_SESSION["id"]);
        session_destroy();
        //echo "Hi " . $_COOKIE["name"];
    }
    

    private function homepage(){
        include("templates/homepage.php");

    }

    private function activities(){
        $uvaMoves_actReviews = $this->loadActReviews();
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        include("templates/activities.php");
    }

    private function loadActReviews(){
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();","s","r_activities");

        if(!isset ($data[0])){
            die("No reviews in the database");
        }
        
        return $data;
    }

    private function profile(){
        include("templates/profile.php");
    }
    private function yourReviews(){
        $uvaMoves_reviews = $this-> loadYourReviews();

        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        include("templates/yourReviews.php");
    }

    private function loadYourReviews(){
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        $data = $this->db->query("select * from uvaMoves_reviews where user_id = ?;",
                                 "i", $user["id"]);
        
        if(!isset($data[0])){
            $error_msg = "No Reviews yet";
        } 
        return $data;                       
    }


    private function yourFavorites(){
        include("templates/yourFavorites.php");
    }

    private function restaurant(){
        $uvaMoves_restReviews = $this->loadRestReviews();
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        include("templates/restaurant.php");
    }

    private function loadRestReviews(){
        
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();","s","r_restaurant");

        if(!isset ($data[0])){
            die("No Reviews in the database");
        }
        
        return $data;
    }

    private function review(){

        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        if(!empty($_POST["r_name"]) && !empty($_POST["review"])){
            $insert =$this->db->query("insert into uvaMoves_reviews (user_id, category, r_name, review, rating)
                                    values (?,?,?,?,?);","isssi",$user["id"],$_POST["category"],$_POST["r_name"],
                                    $_POST["review"], $_POST["rating"]);
            
            if ($insert === false) {
                $error_msg = "Error inserting user";
            }
            else{
                header("Location: ?command=yourReviews");
            }

            return;
            
        }
        else{
            $error_msg = "Error inserting user";
        }

        include("templates/review.php");
    }

    private function what(){
        include("templates/what.php");
    }


}