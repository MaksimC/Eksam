<?php

function test_input($data) {
    global $connection;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($connection, $data);
    return $data;
}

function connect_db(){
    global $connection;
    $host="localhost";
    //$user="root";
    //$pass="";
    $user="test";
    $pass="t3st3r123";
    $db="test";
    $connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
    mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logout(){
    $_SESSION=array();
    session_destroy();
    header("Location: ?");
}

function login(){

    global $connection;
    $errors =array();

    if(isset($_SESSION["user"])){
        header("Location: ?page=forum");
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["user"]) || empty($_POST["pass"])) {
                if (empty($_POST["user"])) {
                    $errors[] = "Fill in username!";
                }
                if (empty($POST["pass"])) {
                    $errors[] = "Please enter your password!";
                }

            } else {
                $username = test_input($_POST["user"]);
                $password = test_input($_POST["pass"]);
                $query = "SELECT role FROM mtseljab_forum_users WHERE username='".$username."' AND password=sha1('".$password."')";
                $result = mysqli_query($connection, $query) or die("Error when logging to DB ".mysqli_error($connection));
                $row = mysqli_fetch_assoc($result);
                if ($row) {
                    $_SESSION["user"] = $_POST["user"];
                    header("Location: ?page=forum");
                } else {
                    header("Location: ?page=login");

                }
            }
        }
    }

    include_once('views/login_page.html');
}


function register(){
    global $connection;
    $errors =array();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["user"]) || empty($_POST["pass"])) {
            if (empty($_POST["user"])) {
                $errors[] = "Fill in username!";
            }
            if (empty($POST["pass"])) {
                $errors[] = "Please enter your password!";
            }

        } else {

            $username = test_input($_POST["user"]);
            $query = "SELECT id FROM mtseljab_forum_users WHERE username='$username'";
            $result = mysqli_query($connection,$query);
            $row = mysqli_fetch_assoc($result);
            if($row){
                $errors[] = "User with this name already exists, please choose another one";
            }else{

                $username = test_input($_POST["user"]);
                $password = test_input($_POST["pass"]);
                $query = "INSERT INTO mtseljab_forum_users (username, password) VALUES ('".$username."', sha1('".$password."'))";
                $result = mysqli_query($connection, $query) or die("Error when logging to DB ".mysqli_error($connection));
                $row = mysqli_insert_id($connection);
                if ($row) {
                    $_SESSION["user"] = $_POST["user"];
                    header("Location: ?page=forum");
                } else {
                    header("Location: ?page=login");
                }
            }
        }
    } else {
        header ("Location: ?page=startpage");
    }

    include_once('views/login_page.html');
}


function show_forum (){

    global $connection;

    if (empty($_SESSION["user"])){
        header ("Location: ?page=login");
    }else{
        $query = "SELECT id, user, forumpost FROM mtseljab_forum ORDER BY id ASC";
        $result = mysqli_query($connection, $query);

    }

    include_once ("views/forum.html");

}

function post_message(){
    global $connection;
    $errors =array();

    if (empty($_SESSION["user"])){
        header("Location: ?page=login");
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if (empty($_POST["forumpost"])) {
            $errors[] = "Fill in username!";
        }else{

            $forumpost = test_input($_POST["forumpost"]);
            $query = "INSERT INTO mtseljab_forum (user, forumpost) VALUES ('".$_SESSION["user"]."', '".$forumpost."') ";
            $result = mysqli_query($connection, $query);
            $row = mysqli_insert_id($connection);
            if($row){
                header ("Location: ?page=forum");
            }
            else{
                header ("Location: ?page=start");
            }
        }
    }
    include_once ("views/forum.html");
}

function delete_msg (){

    global $connection;
    if (empty($_SESSION["user"])){
        header ("Location: ?page=login");
    }

    if($_SERVER["REQUEST_METHOD"]=="POST") {
        $id = test_input($_POST["id"]);
        $query = "DELETE FROM mtseljab_forum  WHERE id='$id'";
        $result = mysqli_query($connection, $query);
        $affectedrows = mysqli_affected_rows($connection);
        if($affectedrows){
            header("Location: ?page=forum");
        } else {
            header("Location: ?page=forum");
        }

    }

    include_once ("views/delete_bins.html");

}