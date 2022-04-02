<?php

class UvaMoves{
    private $command;

    public function __construct($command)
    {
        $this->command = $command;
        
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

        include("templates/homepage.php");

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
        header("Location: ?command=restaurant");
        include("templates/restaurant.php");
    }

    private function review(){
        include("templates/review.php");
    }

    private function what(){
        include("templates/what.php");
    }


}