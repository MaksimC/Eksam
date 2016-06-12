<?php

session_start();
require_once ("functions.php");
connect_db();

$page = "start";

if (isset($_GET["page"]) && $_GET["page"]!=""){
    $page = htmlspecialchars($_GET["page"]);
}

include_once ("views/header.html");

switch ($page){
    case "login":
        login();
        break;

    case "register":
        register();
        break;

    case "logout":
        logout();
        break;

    case "forum":
        show_forum();
        break;

    case "post_msg":
        post_message();
        break;

    case "delete":
        delete_msg();
        break;

    case "startpage":
        include_once ("views/start_page.html");


    default:
        include_once ("views/start_page.html");
        break;
}
