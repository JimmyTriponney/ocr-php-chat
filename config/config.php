<?php

ini_set('display_errors','on');
error_reporting(E_ALL);

//Fonction de redirection
function redirect($path){
    $path = $path === '/' ? 'index.php' : $path;
    header('Location: '.$path);
};

// Connexion à la base
$db_host ='localhost';
$db_user ='root';
$db_pass ='';
$db_db   ='ocr_php';

//Démarrage de la session
session_start();

//Connexion à la base
function db_on(){
    global $db_host;
    global $db_user;
    global $db_pass;
    global $db_db;
    return mysqli_connect($db_host,$db_user,$db_pass,$db_db);
}
//Déconnexion à la base
function db_off($db){
    mysqli_close($db);
}

//Visualisation pour débugage
function debug($var){
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

//Filtre des données envoyé
function chat_encode($value){
    $value = trim($value);
    $value = htmlentities($value);//Echappement du html
    return addslashes($value);//Echappement de guillemets
}
function chat_decode($value){
    $value = html_entity_decode($value);
    return stripslashes($value);
}
function chat_xss($key){
    return filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
}

//Implémentation en SESSION
function chat_sess($key, $value){
    return $_SESSION['chat'][$key] = chat_encode( $value );
}
function chat_get_sess($key){
    if( !isset($_SESSION['chat'][$key]) || empty($_SESSION['chat'][$key]) ){//Si la donné cherché en session n'existe pas
        return false;
    }
    return chat_decode( $_SESSION['chat'][$key] );
}
function chat_save_pseudo($pseudo){
    chat_sess('pseudo', $pseudo);
}
function chat_save_error($message){
    chat_sess('error', $message);
}

//Récupération des messages
function get_messages(){
    $db = db_on();//Connexion

    if( !$db ){
        return false;
    }

    $query = 'SELECT * FROM `chat` ORDER BY `id` DESC';
    $req = mysqli_query($db, $query);
    db_off($db);//Déconnexion

    return $req->num_rows == 1 ? false : $req;
}

?>