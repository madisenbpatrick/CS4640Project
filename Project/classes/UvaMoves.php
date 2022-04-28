<?php

class UvaMoves
{
    private $command;
    private $db;

    public function __construct($command)
    {
        $this->command = $command;

        $this->db = new Database();
    }

    public function run()
    {
        switch ($this->command) {
            case "login":
                $this->login();
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
            case "image":
                $this->image();
                break;

            case "editProfile":
                $this->editProfile();
                break;

                // default: 
                //     $this->homepage();
        }
    }

    private function login()
    {
        if (!isset($_COOKIE["email"])) {
            // they need to see the login
            $command = "login";
        } else {
            // if login go straight to page 
            $user = [
                "name" => $_SESSION["name"],
                "email" => $_COOKIE["email"],
                "id" => $_SESSION["id"],
                "url" => $_COOKIE["url"],
                // "url" => empty($_GET["command"])? "homepage" : $_GET["command"],

            ];
            $url = $user["url"];
            header('Location: ?command=' . $url);
            //header("Location: ?command=review");
        }

        if (isset($_POST["email"]) && ($_POST["email"] != "") && $_POST["password"] != "") {
            $email_regex = "/^[\w\-\.+]+@([\w\-]+\.)+[\w\-]{2,4}$/";


            $pwd_regex = "/[\w\-\.@]{8,15}/";
            $valid_email = preg_match($email_regex, $_POST["email"]) ? true : false;
            if (!$valid_email) {
                $error_msg = "<div class='alert alert-danger'>you have not provided valid email!</div>";
                return false;
            }
            // include password length check 
            if (preg_match($pwd_regex, $_POST["password"]) == 1 && strlen($_POST["password"]) < 16) {
                $error_msg = "Your password length should be between 8 and 15";

                return false;
            }
            $data = $this->db->query("select * from uvaMoves_users where email = ?;", "s", $_POST["email"]);
            if ($data === false) {
                $error_msg = "Error checking for user";
            } else if (!empty($data)) {
                if (password_verify($_POST["password"], $data[0]["password"])) {
                    $name = $_SESSION['name'] = $data[0]["name"];
                    $email = $_SESSION['email'] = $data[0]["email"];
                    $id = $_SESSION['id'] = $data[0]["id"];
                    setcookie("name", $name, time() + 3600);
                    setcookie("email", $email, time() + 3600);
                    setcookie("id", $id, time() + 3600);

                    $user = [
                        "name" => $name,
                        "email" => $email,
                        "id" => $id,
                        "url" => isset($_GET["command"]) ? $_GET["command"] : "homepage"
                    ];
                    // header('Location: ' . $_SERVER['HTTP_REFERER']);
                    // set a cookie for the last command 
                    $url = $user["url"];
                    header('Location: ?command=' . $url);
                    //header("Location: ?command=review");
                } else {
                    $error_msg = "Wrong password";
                }
            } else { // empty, no user found
                $insert = $this->db->query(
                    "insert into uvaMoves_users (name, email, password) values (?, ?, ?);",
                    "sss",
                    $_POST["name"],
                    $_POST["email"],
                    password_hash($_POST["password"], PASSWORD_DEFAULT)
                );
                $data2 = $this->db->query("select * from uvaMoves_users where email = ?;", "s", $_POST["email"]);
                if ($insert === false) {
                    $error_msg = "Error inserting user";
                } else {
                    setcookie("name", $_POST["name"], time() + 3600);
                    setcookie("email", $_POST["email"], time() + 3600);
                    setcookie("id", $data2[0]["id"], time() + 3600);

                    $user = [
                        "name" => $_POST["name"],
                        "email" => $_POST["email"],
                        "id" => $data2[0]["id"],
                        // "url" => $_COOKIE["url"],
                        "url" => empty($_GET["command"]) ? "homepage" : $_GET["command"],
                    ];

                    $_SESSION['name'] = $_POST["name"];
                    $_SESSION['email'] = $_POST["email"];
                    $_SESSION['id'] = $data2[0]["id"];
                    $url = $user["url"];
                    header('Location: ?command=' . $url);
                    //header("Location: ?command=review");
                }
            }
        }
        include("templates/login.php");
    }
    private function destroyCookies()
    {
        setcookie("name", "", time() - 3600);
        unset($_SESSION['name']);
        setcookie("email", "", time() - 3600);
        unset($_SESSION['email']);
        setcookie("id", 0, time() - 3600);
        unset($_SESSION["id"]);
        setcookie("url", "", time() - 3600);
        unset($_SESSION['url']);
        session_destroy();
        //echo "Hi " . $_COOKIE["name"];
    }


    private function homepage()
    {
        include("templates/homepage.php");
    }

    private function activities()
    {
        setcookie("url", "review", time() + 3600);
        $_SESSION['url'] = 'review';

        $uvaMoves_actReviews = $this->loadActReviews();

        include("templates/activities.php");
    }

    private function loadActReviews()
    {

        $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();", "s", "r_activities");

        if (!isset($data[0])) {
            die("No reviews in the database");
        }

        return $data;
    }

    private function profile()
    {
        setcookie("url", "profile", time() + 3600);
        $_SESSION['url'] = 'profile';


        if (!isset($_SESSION['email'])) { //if login in session is not set
            header("Location: ?command=login");
        }
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
            "url" => $_COOKIE["url"],
        ];

        include("templates/profile.php");
    }
    private function yourReviews()
    {
        $uvaMoves_reviews = $this->loadYourReviews();

        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],

        ];

        include("templates/yourReviews.php");
    }

    private function loadYourReviews($reviewID = null)
    {
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];
        if (empty($reviewID)) {
            $data = $this->db->query(
                "select * from uvaMoves_reviews where user_id = ? limit 10;",
                "i",
                $user["id"]
            );
        } else {
            $data = $this->db->query(
                "select * from uvaMoves_reviews where user_id = ? and id = ?;",
                "ii",
                $user["id"],
                $reviewID
            );
        }

        if (!isset($data[0])) {
            $error_msg = "No Reviews yet";
        }
        return $data;
    }
    private function editProfile()
    {
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];
        $q = $this->db->query("update uvaMoves_users set email = ?, name=? where id = ?;", "sss", $_POST["email"], $_POST["name"], $user["id"]);
        $name = $this->db->query("select name from uvaMoves_users where id = ?;", "i", $user["id"]);
        $n = $name[0]["name"];
        setcookie("name", $n, time() + 3600);
        $_SESSION['name'] = $name;
        $e = $this->db->query("select email from uvaMoves_users where id = ?;", "i", $user["id"]);
        $email = $e[0]["email"];
        setcookie("email", $email, time() + 3600);
        $_SESSION['email'] = $email;
        header("Location: ?command=profile");

        return;
    }

    private function editReview()
    {

        $uvaMoves_reviews = $this->loadYourReviews();
        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];
        // user submits edited review, post request
        if (!empty($_POST["r_name"]) && !empty($_POST["review"])) {
            if (!empty($_POST["reviewID"])) {
                $q = $this->db->query(
                    "update uvaMoves_reviews set category = ?, r_name = ?, review = ?, rating = ?
                                    where user_id = ? and id = ?;",
                    "sssiii",
                    $_POST["category"],
                    $_POST["r_name"],
                    $_POST["review"],
                    $_POST["rating"],
                    $user["id"],
                    $_POST["reviewID"]
                );
            } else {

                $q = $this->db->query(
                    "insert into uvaMoves_reviews (user_id, category, r_name, review, rating)
                                        values (?,?,?,?,?);",
                    "isssi",
                    $user["id"],
                    $_POST["category"],
                    $_POST["r_name"],
                    $_POST["review"],
                    $_POST["rating"]
                );
            }


            if ($q === false) {
                $error_msg = "Error in managing database";
            } else {
                header("Location: ?command=yourReviews");
            }

            return;
        }
        // user clicks edit button, get request
        if (isset($_GET["reviewID"])) {
            $review = $this->loadYourReviews($_GET["reviewID"]);
            include("templates/editReview.php");
        }
    }
    function deleteReview()
    {
        if (isset($_GET["reviewID"])) {
            $query = $this->db->query("delete from uvaMoves_reviews where id = ?", "i", $_GET["reviewID"]);
            if (!$query) {
                die("Error Deleting review");
            }
        }
        header("Location: ?command=yourReviews");
    }

    private function yourFavorites()
    {
        include("templates/yourFavorites.php");
    }

    private function restaurant()
    {
        setcookie("url", "review", time() + 3600);
        $_SESSION['url'] = 'review';

        $uvaMoves_restReviews = $this->loadRestReviews();

        include("templates/restaurant.php");
    }

    private function loadRestReviews()
    {


        $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();", "s", "r_restaurant");

        if (!isset($data[0])) {
            die("No Reviews in the database");
        }

        return $data;
    }

    private function review()
    {
        setcookie("url", "review", time() + 3600);
        $_SESSION['url'] = 'review';

        if (!isset($_SESSION['email'])) { //if login in session is not set
            header("Location: ?command=login");
        }

        $user = [
            "name" => $_COOKIE["name"],
            "email" => $_COOKIE["email"],
            "id" => $_COOKIE["id"],
        ];



        if (!empty($_POST["r_name"]) && !empty($_POST["review"])) {
            $insert = $this->db->query(
                "insert into uvaMoves_reviews (user_id, category, r_name, review, rating)
                                    values (?,?,?,?,?);",
                "isssi",
                $user["id"],
                $_POST["category"],
                $_POST["r_name"],
                $_POST["review"],
                $_POST["rating"]
            );

            if ($insert === false) {
                $error_msg = "Error inserting user";
            } else {
                header("Location: ?command=yourReviews");
            }

            return;
        } else {
            $error_msg = "Error inserting user";
        }

        include("templates/review.php");
    }

    private function what()
    {
        $uvaMoves_whatReview = $this->loadWhat();

        if (isset($_COOKIE["name"]) && isset($_COOKIE["email"]) && isset($_COOKIE["id"])) {
            $user = [
                "name" => $_COOKIE["name"],
                "email" => $_COOKIE["email"],
                "id" => $_COOKIE["id"],
            ];
        }
        // $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();","s","r_restaurant");

        include("templates/what.php");
    }

    private function loadWhat()
    {

        // $data = $this->db->query("select * from uvaMoves_reviews where category = ? order by rand();","s","r_restaurant");

        $data = $this->db->query("select * from uvaMoves_reviews order by rand() limit 1;");

        if (!isset($data[0])) {
            die("No questions in the database");
        }
        //$question = $data[0];
        return $data;
    }

    public function searchMap()
    {

        $nearby_json = null;

        if (isset($_GET["next_page"]) && !empty($_GET["next_page"])) {
            $nearby_json = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?pagetoken=" . $_GET["next_page"] . "&key=" . Config::$map["api_key"], true));
            // $nearby_json = json_decode( file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?pagetoken=Aap_uEAzuhIKrcd5LVeCxV6lFTFtb6K1t86DFD95uixBNORXZ-VDwZngUUcjOEc3Kz0KPDdv_H3sLbviLUKkGaJXEKRDxUR52kKkysXnUycejdIyfv5xhQ4-7RD6GzJDC6mRDG59oV4zu1dJ3oPvP0_oMXQ5dQBcNsGSHrAcNCDgRgOeqIhI8J_sNWv-dlk4ysxxl5KNkZyihB0wEZEt2riW7tGrhAO53M7d3-gisRqSPl4l0klHT5wsBhxv3FRGfmf5-7bXKZbp6sZqiOqEjxbeNFxMXctoDOAH-1BKvywONozHj8rPW9wfoelxqEJ47cfALIuNWKV9MJgm86OwEI6rEEKa6lIME0HUCdy9SplThLfYrxoRJ3j8YVn66QA4wjha-BQEEjnJBBPzOY0dkx3stjyU8kHP9CHaQ5ob50-BIVKA7CvFu7W7kFuA&key=AIzaSyBJKHyxTsg6-mlXDK-ahlEv7bSziy63oCY", true));

            // echo var_dump($_GET["next_page"]);

        } else {
            $cor = ['38.054405898608515', '-78.49734770169421'];
            $nearby_json = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?keyword=&location=" . $cor[0] . "%2C" . $cor[1] . "&radius=1500&type=restaurant&key=" . Config::$map["api_key"], true));
        }

        if ($nearby_json === false) {
            echo "something is wrong";
            return;
        } else {
            $next_page_token = $nearby_json->next_page_token;
            $html_arr = array();
            $img_width = 200;
            if (isset($_GET["width"])) {
                $img_width = intval($_GET["width"] / 3);
            }
            foreach ($nearby_json->results as $idx => $item) {
                $lat_lng = $item->geometry->location->lat . " " . $item->geometry->location->lng;
                $photo = json_decode(json_encode($item->photos[0], JSON_PRETTY_PRINT), true);

                $html = "<div id=" . $idx . " class=col-md-4><div class=card mb-4 box-shadow><img class=card-img-top src=?command=image&width=" . $img_width . "&ref=" . $photo["photo_reference"] . " alt=restaurant image><div class=card-body><p class=card-text>Name: " . $item->name . "</p><p class=card-text>Address: " . $item->vicinity . "</p><div class=d-flex justify-content-between align-items-center><div class=btn-group><button type=button class=btn btn-sm btn-outline-secondary id=" . $idx . "data-latlng=" . $lat_lng . ">View On Map</button></div></div></div></div>";

                array_push($html_arr, $html);
            }
            array_push($html_arr, $next_page_token);
            header('Content-type:application/json;charset=utf-8');
            echo json_encode($html_arr, JSON_UNESCAPED_UNICODE);
        }
    }
    //return the image given reference
    function image()
    {
        if (isset($_GET["ref"]) && isset($_GET["width"])) {

            // $img = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&photo_reference=Aap_uEA7vb0DDYVJWEaX3O-AtYp77AaswQKSGtDaimt3gt7QCNpdjp1BkdM6acJ96xTec3tsV_ZJNL_JP-lqsVxydG3nh739RE_hepOOL05tfJh2_ranjMadb3VoBYFvF0ma6S24qZ6QJUuV6sSRrhCskSBP5C1myCzsebztMfGvm7ij3gZT&key=AIzaSyBJKHyxTsg6-mlXDK-ahlEv7bSziy63oCY";
            $img = Config::$map["photo_search"] . "maxwidth=" . $_GET["width"] . "&photo_reference=" . $_GET["ref"] . "&key=" . Config::$map["api_key"];

            $fp = fopen($img, 'rb');
            header('Content-Type: image/jpeg');
            fpassthru($fp);
            exit;
        } else {
            echo "no ref?";
        }
    }
}
