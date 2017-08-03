<?php
require_once('inc/init.inc.php');//on inclue le doc init

//-----------TRAITEMENT DE LA REQUETE AJAX--------------//
if($_SERVER['REQUEST_METHOD'] == 'GET') {

	// var_dump($_GET);

		$show_me_data=$pdo->prepare("

			SELECT a.titre, a.description_courte, a.prix, a.photo, m.pseudo
			FROM annonce a, membre m
			WHERE a.id_membre=m.id_membre
			ORDER BY a.date_enregistrement DESC LIMIT 0,3;
			");

		$show_me_data->execute();

		echo json_encode($show_me_data->fetchAll());

		}

?>

