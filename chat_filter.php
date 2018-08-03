<?php

require_once('config/config.php');

if( !isset($_POST) ){ // Aucune donné n'a été envoyé
    chat_save_error('Une erreur est survenue.');//Enregistrement du message d'erreur
    redirect('/');//Redirection vers le chat
}
else if( !isset($_POST['pseudo']) || empty($_POST['pseudo']) ){ // Pseudo inexistant ou vide
    chat_save_error('Vous n\'avez pas renseigné de pseudo.');//Enregistrement du message d'erreur
    redirect('/');//Redirection vers le chat
}
else if( strlen( $_POST['pseudo'] ) > 250 ){// Pseudo trop long
    chat_save_error('Le pseudo doit faire moins de 250 caractéres.');//Enregistrement du message d'erreur
    redirect('/');//Redirection vers le chat
}
//Le pseudo existe et est valide on l'enregistre en session
chat_save_pseudo( $_POST['pseudo'] );//Enregistrement du pseudo en session

if( !isset($_POST['message']) || empty($_POST['message']) ){ // Message inexistant ou vide
    chat_save_error('Vous n\'avez pas renseigné de message.');//Enregistrement du message d'erreur en session
    redirect('/');//Redirection vers le chat
}

//Si le code arrive jusque là c'est que tout est ok
$pseudo = chat_encode( chat_xss('pseudo') );//Echappement et filtre contre les failles xxs
$message = chat_encode( chat_xss('message') );//Echappement et filtre contre les failles xxs
$date = new DateTime('NOW');//Initialisation de l'objet DateTime au moment T
$date = $date->format('d/m/Y H:i:s');//Formatage de la date

//Requête SQL
$query = 'INSERT INTO `chat` (`pseudo`,`message`,`createdate`) VALUES ("'.$pseudo.'","'.$message.'","'.$date.'")';

//Appel à la base
$db = db_on();//Connexion

if( !$db ){// Si l'appel plante
    chat_save_error('Impossible de ce connecter à la base.');//Enregistrement du message d'erreur en session
    redirect('/');//Redirection vers le chat
}

var_dump($req = mysqli_query($db,$query));//Envoi de la requête à la base

if( !$req ){// Si la requête échoue
    chat_save_error('Une erreur est survenue lors de l\'enregistrement des du message.');//Enregistrement du message d'erreur en session
    redirect('/');//Redirection vers le chat
}

db_off($db);//Déconnexion
redirect('/');//Redirection vers le chat

?>