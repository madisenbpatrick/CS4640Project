<?php

// Register the autoloader
spl_autoload_register(function($classname) {
    include "classes/$classname.php";
});

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db = new mysqli(Config::$db["host"], Config::$db["user"], Config::$db["pass"], Config::$db["database"]);

$db->query("create table uvaMoves_users (
    id int not null auto_increment,
    email text not null,
    name text not null,
    password text not null,
    primary key (id)
);");

$db->query("create table uvaMoves_reviews (
    id int not null auto_increment,
    user_id int not null, 
    category text not null,
    r_name text not null,
    review text not null,
    rating int not null,
    primary key (id)
);");

$db->query("create table uvamoves_restaurants (
    id int not null,
    restaurant_name text not null,
    image text not null,
    address text not null,
    PRIMARY KEY (id)
);");

