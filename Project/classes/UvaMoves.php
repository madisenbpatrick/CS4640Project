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
            case "editReview":
                $this->editReview();
                break;
            case "deleteReview":
                $this->deleteReview();
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
            case "searchMap":
                $this->searchMap();
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
            // if login go straight to page 
            $user = [
                "name" => $_COOKIE["name"],
                "email" => $_COOKIE["email"],
                "id" => $_COOKIE["id"],
                "url" => $_COOKIE["url"],
            ];
            $url = $user["url"];
            header('Location: ?command='. $url);
            //header("Location: ?command=review");
        }

        if (isset($_POST["email"]) && ($_POST["email"] != "") && $_POST["password"] != "") {
            $email_regex = "/^[\w\-\.+]+@([\w\-]+\.)+[\w\-]{2,4}$/";
            $valid_email = preg_match($email_regex, $_POST["email"])? true: false;
            if (!$valid_email){
                return false;
            }
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
                        "url" => $_COOKIE["url"],
                    ];

                    $_SESSION['name'] = $data[0]["name"];
                    $_SESSION['email'] = $data[0]["email"];
                    $_SESSION['id'] = $data[0]["id"];

                    // header('Location: ' . $_SERVER['HTTP_REFERER']);
                        // set a cookie for the last command 
                    $url = $user["url"];
                    header('Location: ?command='. $url);
                    //header("Location: ?command=review");
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

                    $user = [
                        "name" => $_COOKIE["name"],
                        "email" => $_COOKIE["email"],
                        "id" => $_COOKIE["id"],
                        "url" => $_COOKIE["url"],
                    ];

                    $_SESSION['name'] = $_POST["name"];
                    $_SESSION['email'] = $_POST["email"];
                    $_SESSION['id'] = $data2[0]["id"];

                    $url = $user["url"];
                    header('Location: ?command='. $url);
                    //header("Location: ?command=review");
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
        setcookie("url","",time()-3600);
        unset($_SESSION['url']);
        session_destroy();
        //echo "Hi " . $_COOKIE["name"];
    }
    

    private function homepage(){
        include("templates/homepage.php");

    }

    private function activities(){
        setcookie("url", "review", time() + 3600);
        $_SESSION['url'] = 'review';

        $uvaMoves_actReviews = $this->loadActReviews();

        include("templates/activities.php");
    }

    private function loadActReviews(){

        $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();","s","r_activities");

        if(!isset ($data[0])){
            die("No reviews in the database");
        }
        
        return $data;
    }

    private function profile(){
        setcookie("url", "profile", time() + 3600);
        $_SESSION['url'] = 'profile';

        if(!isset($_SESSION['email'])){ //if login in session is not set
            header("Location: ?command=login");
        }

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
    
    private function loadYourReviews($reviewID = null){
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];
        if (empty($reviewID)){
            $data = $this->db->query("select * from uvaMoves_reviews where user_id = ? limit 10;",
            "i", $user["id"]);
        } else {
            $data = $this->db->query("select * from uvaMoves_reviews where user_id = ? and id = ?;",
            "ii", $user["id"], $reviewID);
        }
        
        if(!isset($data[0])){
            $error_msg = "No Reviews yet";
        } 
        return $data;                       
    }
    
    private function editReview(){
        
        $uvaMoves_reviews = $this-> loadYourReviews();
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];
        // user submits edited review, post request
        if(!empty($_POST["r_name"]) && !empty($_POST["review"])){
            if (!empty($_POST["reviewID"])){
                $q = $this->db->query("update uvaMoves_reviews set category = ?, r_name = ?, review = ?, rating = ?
                                    where user_id = ? and id = ?;","sssiii", $_POST["category"],$_POST["r_name"],
                                    $_POST["review"], $_POST["rating"], $user["id"], $_POST["reviewID"]);
            } else {

                $q =$this->db->query("insert into uvaMoves_reviews (user_id, category, r_name, review, rating)
                                        values (?,?,?,?,?);","isssi",$user["id"],$_POST["category"],$_POST["r_name"],
                                        $_POST["review"], $_POST["rating"]);
            }

            
            if ($q === false) {
                $error_msg = "Error in managing database";
            }
            else{
                header("Location: ?command=yourReviews");
            }

            return;
            
        }
        // user clicks edit button, get request
        if (isset($_GET["reviewID"])){
            $review = $this->loadYourReviews($_GET["reviewID"]);
            include("templates/editReview.php");
        }

    }
    function deleteReview(){
        if (isset($_GET["reviewID"])){
            $query = $this->db->query("delete from uvaMoves_reviews where id = ?", "i", $_GET["reviewID"]);
            if (!$query){
                die("Error Deleting review");
            }
        }
        header("Location: ?command=yourReviews");
    }

    private function yourFavorites(){
        include("templates/yourFavorites.php");
    }

    private function restaurant(){
        setcookie("url", "review", time() + 3600);
        $_SESSION['url'] = 'review';
        
        $uvaMoves_restReviews = $this->loadRestReviews();

        include("templates/restaurant.php");
    }

    private function loadRestReviews(){
        

        $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();","s","r_restaurant");

        if(!isset ($data[0])){
            die("No Reviews in the database");
        }
        
        return $data;
    }

    private function review(){
        setcookie("url", "review", time() + 3600);
        $_SESSION['url'] = 'review';

        if(!isset($_SESSION['email'])){ //if login in session is not set
            header("Location: ?command=login");
        }

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
        $uvaMoves_whatReview = $this->loadWhat();

        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        // $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();","s","r_restaurant");

        include("templates/what.php");
    }

    private function loadWhat(){

        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];

        // $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();","s","r_restaurant");

        $data = $this->db->query("select * from uvaMoves_reviews order by rand() limit 1;");

        if (!isset($data[0])) {
            die("No questions in the database");
        }
        //$question = $data[0];
        return $data;
        
    }

    public function searchMap(){
        //do a google search by name
        //result returned in json
        //need api key, so hide in server
        // echo result from db
        //$restaurants = $this->db->query("select r_cor from restaurants where r_name = ?", "s", "villa diner");
        // $restaurants = json_encode(["lat" => 38.054405898608515, "lng" => -78.49734770169421])
        // header('Content-type:application/json;charset=utf-8');
        // $cor = explode(",",$restaurants[0]["r_cor"]);
        // echo json_encode($cor, JSON_UNESCAPED_UNICODE);
        //header('Content-type:application/json;charset=utf-8');
        // $cor = ['38.054405898608515', '-78.49734770169421'];
        // echo json_encode($cor, JSON_UNESCAPED_UNICODE);

        header('Content-type:application/json;charset=utf-8');
        $cor = ['38.054405898608515', '-78.49734770169421'];
        echo json_encode($cor, JSON_UNESCAPED_UNICODE);
        return;
    }
}

