<?php

require_once('config/config.php');

//Récupération du pseudo
$pseudo = chat_get_sess('pseudo') ? chat_get_sess('pseudo') : '';
//Récupération du message d'erreur
$error = chat_get_sess('error') ? chat_get_sess('error') : '';
//Récupération des messages
$messages = get_messages();

//Affichage de la page de chat
require_once('views/chat.php');

//Réinitialisation du message d'erreur
chat_save_error('');

?>