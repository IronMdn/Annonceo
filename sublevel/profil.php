<?php
require_once("inc/init.inc.php");

if(!userIsConnected()) {// si le membre n'est pas connecté, il ne doit pas avoir accés à la page profil

	header("location:connexion.php"); // nous l'invitons à se connecter
}

//---------------------MODIFICATION DES DONNEES DE L'UTILISATEUR-----------------------//
//---------------------VERIFICATION DES CHAMPS DE FORMULAIRE-----------------------//

if (!empty($_POST) && isset($_POST['id_membre'])) {

	foreach ($_POST as $key => $value) {//pour éviter des injections sql

		$value=htmlspecialchars(addslashes($value));

	}

	if (strlen($_POST['pseudo'])<1 || strlen($_POST['pseudo'])>20) {

		$message.='<div class="">Le nombre de charactères de pseudo doit etre entre 1 et 20</div>';

	}

	if (!preg_match('/^[a-zA-Z0-9-_.]+$/', $_POST['pseudo'])) {

		$message.='<div class="">Le pseudo ne peut pas contenir des  littres, chiffres et - ou _ ou .</div>';

	}

	if (strlen($_POST['nom'])<1 || strlen($_POST['nom'])>20) {

		$message.='<div class="">Le nombre de charactères de nom doit etre entre 1 et 20</div>';

	}

	if (!preg_match('/^[a-zA-Z0-9-_.]+$/', $_POST['nom'])) {

		$message.='<div class="">Le nom ne peut pas contenir des littres, chiffres et - ou _ ou .</div>';

	}

	if (strlen($_POST['prenom'])<1 || strlen($_POST['nom'])>20) {

		$message.='<div class="">Le nombre de charactères de prenom doit etre entre 1 et 20</div>';

	}

	if (!preg_match('/^[a-zA-Z0-9-_.]+$/', $_POST['prenom'])) {

		$message.='<div class="">Le prenom ne peut pas contenir des littres, chiffres et - ou _ ou .</div>';

	}

	if (strlen($_POST['telephone'])<1 || strlen($_POST['telephone'])>20) {

		$message.='<div class="">Le nombre de charactères de nom doit etre entre 1 et 20</div>';

	}

	if (!preg_match('/^[0-9]+$/', $_POST['telephone'])) {

		$message.='<div class="">Le numéro de téléphone ne peut contenir que des chiffres</div>';

	}

	$ext = array('yopmail.com', 'mailinator.com');//liste des email que nous voulons pas
	$email_tab = explode('@', $_POST['email']);

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && in_array($ext, $email_tab)) {//nous vérifions qu'email soit valide

		$message.='<div class="">Le format d\'email n\'est pas valide</div>';

	}

	//nous envoyons une requete à la BDD pour vérifier qu'un tel peudo existe déjà
	$pseudo=$pdo->prepare("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");
	$pseudo->execute();

	if($pseudo -> rowCount() > 0){//si oui

		$message.= '<div>Ce pseudo est déjà utilisé</div>';

	}
	

	$id=$pdo->prepare("SELECT * FROM membre WHERE id_membre=".$_SESSION['membre']['id_membre']."");//on récupere id-membre de $_SESSION
	$id->execute();
	$passe=$id->fetch(PDO::FETCH_ASSOC);

	if (empty($message)) {//si le formulaire ne contient pas d'erreurs nous changeons les données de membre dans la BDD

		$signin=$pdo->prepare("REPLACE INTO membre (id_membre, pseudo, mot_de_passe, salt, nom, prenom, telephone, email, civilite) VALUES (:id_membre, :pseudo, :mot_de_passe, :salt, :nom,:prenom, :telephone, :email, :civilite)");

		$signin->bindParam(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
		$signin->bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
		$signin->bindParam(':mot_de_passe', $passe['mot_de_passe'], PDO::PARAM_STR);
		$signin->bindParam(':salt', $passe['salt'], PDO::PARAM_STR);
		$signin->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
		$signin->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
		$signin->bindParam(':telephone', $_POST['telephone'], PDO::PARAM_INT);
		$signin->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
		$signin->bindParam(':civilite', $_POST['civilite'], PDO::PARAM_STR);

		if($signin->execute()) {//si la requete a eu lieu avec succès

			$message='<div class="alert alert-success">Les données ont étés modifiées avec succes</div>';

		}

	}

	$_GET['action']='modification_donnees';
}

//---------------------INSERTION D'UNE ANNONCE-----------------------//
//---------------------VERIFICATION DES CHAMPS DE FORMULAIRE-----------------------//

if (!empty($_POST) && isset($_POST['titre'])) {

	foreach ($_POST as $key => $value) {//pour éviter les injections sql

		$value=htmlspecialchars(addslashes($value));

	}

	if (strlen($_POST['titre'])<1 || strlen($_POST['titre'])>60) {

		$message.='<div class="alert alert-danger>Le nombre de charactères de titre doit etre entre 1 et 60</div>';

	}

	if (!preg_match('/^[0-9a-zA-Z-.,?!]+$/', $_POST['prix'])) {

		$message.='<div class="alert alert-danger>Le nombres de charactères de pays ne peut contenir que des lettre et -.,?!</div>';

	}

	if (strlen($_POST['desc_courte'])<1 || strlen($_POST['desc_courte'])>600) {

		$message.='<div class="alert alert-danger>Le nombre de charactères de description courte doit etre entre 1 et 180</div>';

	}

	if (strlen($_POST['desc_longue'])<1 || strlen($_POST['desc_longue'])>1200) {

		$message.='<div class="alert alert-danger>Le nombres de charactères de description longue doit etre entre 1 et 250</div>';

	}

	if (strlen($_POST['prix'])<1 || strlen($_POST['prix'])>5) {

		$message.='<div class="alert alert-danger>Le nombre de charactères de champs prix ne peut pas etre supérieur à 5</div>';

	}

	if (!preg_match('/^[0-9]+$/', $_POST['prix'])) {

		$message.='<div class="alert alert-danger>Le nombres de charactères de prix ne peut contenir que des chiffres</div>';

	}

	if (strlen($_POST['pays'])<1 || strlen($_POST['pays'])>25) {

		$message.='<div class="alert alert-danger>Le nombres de charactères de pays doit etre entre 1 et 25</div>';

	}

	if (!preg_match('/^[a-zA-Z]+$/', $_POST['pays'])) {

		$message.='<div class="alert alert-danger>Le nombres de charactères de pays ne peut contenir que des lettre</div>';

	}

	if (strlen($_POST['ville'])<1 || strlen($_POST['ville'])>25) {

		$$message.='<div class="alert alert-danger>Le nombres de charactères de ville doit etre entre 1 et 25</div>';

	}

	if (!preg_match('/^[a-zA-Z]+$/', $_POST['ville'])) {

		$message.='<div class="alert alert-danger>Le nombres de charactères de ville ne peut contenir que des lettre</div>';

	}

	if (strlen($_POST['adresse'])<1 || strlen($_POST['adresse'])>50) {

		$$message.='<div class="alert alert-danger>Le nombres de charactères de l\'adress doit etre entre 1 et 50</div>';

	}

	if (!preg_match('/^[0-9]+$/', $_POST['code_postal'])) {

		$$message.='<div class="alert alert-danger>Le nombres de charactères de champs \'code postal\' ne peut dépasser 5 et ne doit contenir que des lettre</div>';

	}

if (empty($message)) {//si le formulaire ne contient pas d'erreurs

	//--------------------------------INSERTION DE PHOTOS DANS LA TABLE 'PHOTO'-----------------------------//

	$photo_bdd=array();

	for ($i=1; $i<=count($_FILES); $i++) {//pour chaque photo postée

		if(!empty($_FILES[$i]['name']))  {//si la photo est bien présent dans FILES

			$nom_photo = substr($_POST['titre'], 0, 3) . '_' . $_FILES[$i]['name'];//création du nom du photo

			array_push($photo_bdd, URL . "sublevel/img/$nom_photo");//url pour la photo
					
			$photo_dossier = RACINE_SITE . "sublevel/img/$nom_photo";//chemin physique de la photo

			copy($_FILES[$i]['tmp_name'],$photo_dossier);//nous déplaçons la photo de dossier temporaire 'tmp' dans le dossier 'img' que nous avons créé préalablement  

		}
	}

	$photo=$pdo->prepare("INSERT INTO photo (photo1, photo2, photo3, photo4, photo5) VALUES (:photo1, :photo2, :photo3, :photo4, :photo5)");//on les insère dans la BDDD

	$photo->bindParam(':photo1', $photo_bdd[0], PDO::PARAM_STR);
	$photo->bindParam(':photo2', $photo_bdd[1], PDO::PARAM_STR);
	$photo->bindParam(':photo3', $photo_bdd[2], PDO::PARAM_STR);
	$photo->bindParam(':photo4', $photo_bdd[3], PDO::PARAM_STR);
	$photo->bindParam(':photo5', $photo_bdd[4], PDO::PARAM_STR);
	$photo->bindParam(':photo5', $photo_bdd[5], PDO::PARAM_STR);

	$photo->execute();


	//------RECUPERATION DE ID PHOTO QUI VIENT D'ETRE INSERE------------//
	$recup_id_photo=$pdo->lastInsertId(); 

	//------RECUPERATION DE ID CATEGORIE DE LA TABLE CATEGORIE QUI CORRESPOND A LA CATEGORIE CHIOSI DANS LE FORMULAIRE DE DEPOT D'UNE ANNONCE------------//
	$id_categorie=$pdo->prepare("SELECT * FROM categorie WHERE titre='$_POST[categorie]'");
	$id_categorie->execute();
	$recup_id_categorie=$id_categorie->fetch(PDO::FETCH_ASSOC);

	$depot=$pdo->prepare("INSERT INTO annonce (titre, description_courte, description_longue, prix, photo, pays, ville, adresse, cp, id_membre, id_photo, id_categorie) VALUES (:titre, :description_courte, :description_longue, :prix, :photo, :pays, :ville, :adresse, :cp, :id_membre, :id_photo, :id_categorie)");//insertion d'une annonce

	$depot->bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);
	$depot->bindParam(':description_courte', $_POST['desc_courte'], PDO::PARAM_STR);
	$depot->bindParam(':description_longue', $_POST['desc_longue'], PDO::PARAM_STR);
	$depot->bindParam(':prix', $_POST['prix'], PDO::PARAM_INT);
	$depot->bindParam(':photo', $photo_bdd[0], PDO::PARAM_STR);
	$depot->bindParam(':pays', $_POST['pays'], PDO::PARAM_STR);
	$depot->bindParam(':ville', $_POST['ville'], PDO::PARAM_STR);
	$depot->bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
	$depot->bindParam(':cp', $_POST['code_postal'], PDO::PARAM_INT);
	$depot->bindParam(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_INT);//id_membre est récuperé de la $_SESSION
	$depot->bindParam(':id_photo', $recup_id_photo, PDO::PARAM_INT);
	$depot->bindParam(':id_categorie', $recup_id_categorie['id_categorie'], PDO::PARAM_INT);

	if($depot->execute()) {//si insertion a bien eu lieu

		$message='<div class="alert alert-success">Votre annonce a été déposée avec succes</div>';

	}

}

$_GET['action']==='depot_annonce';

}

//-----------------------------MODIFICATION DE MOT DE PASSE DE L'UTILISATEUR-------------------//
if (!empty($_POST) && isset($_POST['mot_de_passe_cur'])) {

	$password_check=$pdo->prepare("SELECT * FROM membre WHERE id_membre=".$_SESSION['membre']['id_membre']."");//récupèration des donnes de l'utilisateur de la BDD
	$password_check->execute();
	$check=$password_check->fetch(PDO::FETCH_ASSOC);

	if (password_hash($_POST['mot_de_passe_cur'], PASSWORD_DEFAULT, array('salt' => $check['salt']))===$check['mot_de_passe']) {
		
		if ($_POST['mot_de_passe_new']===$_POST['mot_de_passe_new_conf']) {//si nouveaux mot de passe confirmé

			$salt = md5(time().rand(1111111111111,9999999999999).'planinata');//salage
			$password_itself=password_hash($_POST['mot_de_passe_new'], PASSWORD_DEFAULT, array('salt' => $salt));
			$change_password=$pdo->prepare("UPDATE membre SET mot_de_passe=:mdp,salt=:salt WHERE id_membre=".$_SESSION['membre']['id_membre']."");//requete de changement de mot de passe

			$change_password->bindParam(':mdp', $password_itself, PDO::PARAM_STR);
			$change_password->bindParam(':salt', $salt, PDO::PARAM_STR);

			if($change_password->execute()) {//so mot de passe a bien été changé

				$message='<div class="alert alert-success">Le mot de passe a été changé avec succes</div>';

			} 

		} else {//sinon si le nouveaux mot de passe n'est pas confirmé -> message d'erreur

				$message='<div class="alert alert-danger">Les nouveaux mots de passes ne sont pas les memes</div>';
		}

	} else {//si le mot de passe rentré n'est pas correcte

		$message='<div class="alert alert-danger">Les mots de passe n\'est pas correct</div>';
	}

	$_GET['action']==='change_mdp';

}


//-----------------------------AFFICHAGE DES ELEMENTS DE TABLEAU DE BORD DE L'UTILISATEUR-------------------//
if (isset($_GET['action']) && $_GET['action']==='affichage_tableau') {
 	
 $content .= '<div style="margin-top: 30px;" class="container-fluid tableau">
 <div class="row">
	<div class="col-md-3">
		<a href="?action=depot_annonce"><button type="button" class="btn btn-default">Déposer une annonce</button></a>
		<a href="?action=affichage_annonce"><button type="button" class="btn btn-default">Afficher mes annonces</button></a>
	</div>
		</div>	
			</div>';

}

//-----------------------------AFFICHAGE DE FORMULAIRE POUR DEPOSER UNE ANNONCE-----------------//

if (isset($_GET['action']) && $_GET['action']==='depot_annonce') {

$cat=$pdo->prepare("SELECT titre FROM categorie");//recupération de tous les titre de la BDD
$cat->execute();
$titre=$cat->fetchAll();

$content.= '<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="form-group">
				    <h4>Deposer une annonce</h4>
			  	</div>
				<div class="form-group">
					<label for="titre">Titre</label>
				    <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre de l\'annonce">
			  	</div>
			  	<div class="form-group">
					<label for="desc_courte">Description courte</label>
				    <textarea class="form-control" rows="3" name="desc_courte" id="desc_courte" placeholder="Description courte de l\'annonce"></textarea>
			  	</div>
			  	<div class="form-group">
					<label for="desc_longue">Description Longue</label>
				    <textarea class="form-control" rows="6" name="desc_longue" id="desc_longue" placeholder="Description longue de l\'annonce"></textarea>
			  	</div>
			  	<div class="form-group">
					<label for="prix">Prix</label>
				    <input type="text" class="form-control" name="prix" id="prix" placeholder="Prix figurant dans l\'annonce">
			  	</div>
			  	<div class="form-group">
					<label for="categorie">Catégorie</label>
				    <select name="categorie" id="categorie" class="form-control">';

					  foreach ($titre as $key => $value) {//affichage des titre renvoyés par la BDD

					  	$content.= "<option value=\"$value[titre]\">$value[titre]<option>";

					  }

					$content.= '</select>

				</div>
		</div>
		<div class="col-md-6">		
				<div class="form-group">
					<label for="photo">Photo</label><br>
					<input type="file" id="photo" name="1" class="form-control">
					<input type="file" id="photo" name="2" class="form-control">
					<input type="file" id="photo" name="3" class="form-control">
					<input type="file" id="photo" name="4" class="form-control">
					<input type="file" id="photo" name="5" class="form-control">
				</div>
				<div class="form-group">
					<label for="pays">Pays</label>
				    <select name="pays" id="pays" class="form-control">
				    <option value="France">France</option>
				    <option value="Allemagne">Allemagne</option>
				    <option value="Angleterre">Angleterre</option>
				    <option value="Espagne">Espagne</option>
				    </select>
			  	</div>
			  	<div class="form-group">
					<label for="ville">Ville</label>
				    <select name="ville" id="ville" class="form-control">
				    <option value="Paris">Paris</option>
				    <option value="Berlin">Berlin</option>
				    <option value="Londre">Londre</option>
				    <option value="Madrid">Madrid</option>
				    </select>
			  	</div>
			  	<div class="form-group">
					<label for="adresse">Adresse</label>
				    <textarea class="form-control" rows="3" name="adresse" id="adresse" placeholder="Adresse figurant dans l\'annonce"></textarea>
			  	</div>
			  	<div class="form-group">
					<label for="code_postal">Code Postal</label>
				    <input type="text" class="form-control" name="code_postal" id="code_postal" placeholder="Code postal figurant dans l\'annonce">
			  	</div>
			  	<button type="submit" class="btn btn-default">Enregistrer</button>
			</form>';
			if(isset($message)) $content.=$message;//affichage des messages d'erreur
		$content.='</div>
	</div>
</div>';

} 

//-----------------------------AFFICHAGE DE DONNES PERSONNELLES DE L'UTILISATEUR-----------------//
if (isset($_GET['action']) && $_GET['action']==='affichage_donnes') {

$content .= '<div style="margin-top: 60px;" class="row">';
$content .= '<ul>';

foreach ($_SESSION['membre'] as $key => $value) {

	if($key!=='id_membre' && $key!=='statut' && $key!=='date_enregistrement') {

		if($key==='mot_de_passe') {

			$content .= "<li style=\"list-style-type: none;\"><b>".ucfirst($key).'</b>'. ": "." ********** "."</li>";

		} else {

		$content .= "<li style=\"list-style-type: none;\"><b>".ucfirst($key).'</b>'. ": ".$value."</li>";

		}
	}	
}

$content .= '</ul>';
$content .= '<a href="?action=modification_donnees&id_membre='.$_SESSION['membre']['id_membre'].'" style="padding-left: 40px;"> >> Modifier</a>';
$content .= '</div>';

}

//-----------------------------AFFICHAGE DE FORMULAIRE POUR MODIFIER LES DONNES PERSONNELLES DE L'UTILISATEUR-----------------//
if (isset($_GET['action']) && $_GET['action']==='modification_donnees') {

$resultat=$pdo->prepare("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");//récuperation de membre de la BDD seloin son id
$resultat->execute();

$membre_info=$resultat->fetch(PDO::FETCH_ASSOC);

$id=(isset($membre_info['id_membre'])) ? $membre_info['id_membre'] : '';
$pseudo=(isset($membre_info['pseudo'])) ? $membre_info['pseudo'] : '';
$mdp=(isset($membre_info['mot_de_passe'])) ? $membre_info['mot_de_passe'] : '';
$nom=(isset($membre_info['nom'])) ? $membre_info['nom'] : '';
$prenom=(isset($membre_info['prenom'])) ? $membre_info['prenom'] : '';
$telephone=(isset($membre_info['telephone'])) ? $membre_info['telephone'] : '';
$email=(isset($membre_info['email'])) ? $membre_info['email'] : '';
$civilite=(isset($membre_info['civilite'])) ? $membre_info['civilite'] : '';

$affichage=$pdo->query("SELECT * FROM membre WHERE id_membre=$_GET[id_membre]");
$content .= '<div class="container">
	<div class="row">
	<div class="col-md-4" style="margin-top: 100px;">
			<a href="?action=change_mdp">Changer le mot de passe</a>
		</div>
		<div class="col-md-4">
			<form action="" method="POST">
				<div class="form-group form-head">
				    <h3>Modification de coordonnes</h3>
			  	</div>
			  	<input type="hidden" class="form-control" name="id_membre" value="'.$id.'">
				<div class="form-group">
					<label for="pseudo">Pseudo</label>
				    <input type="text" class="form-control" name="pseudo" id="pseudo" value="'.$pseudo.'">
			  	</div>
			  	<div class="form-group">
			  		<label for="nom">Nom</label>
				    <input type="text" class="form-control" name="nom" id="nom" value="'.$nom.'">
			  	</div>
			  	<div class="form-group">
			  		<label for="prenom">Prenom</label>
				    <input type="text" class="form-control" name="prenom" id="prenom" value="'.$prenom.'">
			  	</div>
			  	<div class="form-group">
			  		<label for="telephone">Telephone</label>
				    <input type="text" class="form-control" name="telephone" id="telephone" value="'.$telephone.'">
			  	</div>
			  	<div class="form-group">
			  		<label for="email">Email</label>
				    <input type="email" class="form-control" name="email" id="email" value="'.$email.'">
			  	</div>
			  	<div class="form-group">
			  		<label for="civilite">Civilite</label>
				    <select name="civilite" id="civilite" class="form-control">
					  <option value="m"'; if($civilite == "m") $content .= 'selected'; $content .='>Homme</option>
					  <option value="f"'; if($civilite == "f") $content .= 'selected'; $content .='>Femme</option>
					</select>
			  	</div>
			  	<button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
			</form>';
			if(isset($message)) $content .=$message;//affichage des messages d'erreur
		$content .='</div>
	</div>
</div>'; 

}


//-----------------------------MODIFICATION DE MOT DE PASSE DE L'UTILISATEUR-------------------//
if (isset($_GET['action']) && $_GET['action']==='change_mdp') {

$content .= '<div class="container">
	<div class="row">
	<div class="col-md-4" style="margin-top: 100px;">
		<form action="" method="POST">
			<div class="form-group form-head">
				<h4>Modification de mot de passe</h4>
			</div>
			<div class="form-group">
				<label for="pseudo">Mot de passe actuelle</label>
				<input type="password" class="form-control" name="mot_de_passe_cur" id="mot_de_passe_cur" placeholder="Veuillez entrer votre mot de passe actuel">
			</div>
			<div class="form-group">
				<label for="pseudo">Nouveau mot de passe</label>
				<input type="password" class="form-control" name="mot_de_passe_new" id="mot_de_passe_new" placeholder="Veuillez entrer le nouveau mot de passe">
			</div>
			<div class="form-group">
				<label for="pseudo">Nouveau mot de passe</label>
				<input type="password" class="form-control" name="mot_de_passe_new_conf" id="mot_de_passe_new_conf" placeholder="Veuillez confirmer le nouveau mot de passe">
			</div>
			<button type="bsubmit" class="btn btn-default">Enregistrer</button>
			<div class="form-group">';
				if(isset($message)) {$content.=$message;}//affichage des messages d'erreur		
$content .='</div>
</form>		
	</div>
		</div>
			</div>';


}

//--------------------------AFFICHAGE DES ANNONCE---------------------//
if (isset($_GET['action']) && $_GET['action']==='affichage_annonce') {

$affichage_annonce=$pdo->prepare("SELECT * FROM annonce WHERE id_membre=".$_SESSION['membre']['id_membre']."");//requete pour récupere toutes info d'une annonce de la BDD
$affichage_annonce->execute();
$recup_affichage_annonce=$affichage_annonce->fetch(PDO::FETCH_ASSOC);

$content.= '<div style="margin-top: 40px;" class="container">
	<div class="row">
		<div class="col-md-6">';
$content.= '<ul class="list-group">';
$content.= '<li class="list-group-item"><b>Titre</b>: '.$recup_affichage_annonce['titre'].'</li>';
$content.= '<li class="list-group-item"><b>Description courte</b>:<br> <p>'.$recup_affichage_annonce['description_courte'].'</p></li>';
$content.= '<li class="list-group-item"><b>Description longue</b>:<br> <p>'.$recup_affichage_annonce['description_longue'].'</p></li>';
$content.= '<li class="list-group-item"><b>Prix</b>: '.$recup_affichage_annonce['prix'].'</li>';
$content.= '<li class="list-group-item"><figure><img src="'.$recup_affichage_annonce['photo'].'"></figure></li>';
$content.= '<li class="list-group-item"><b>Pays</b>: '.$recup_affichage_annonce['pays'].'</li>';
$content.= '<li class="list-group-item"><b>Ville</b>: '.$recup_affichage_annonce['ville'].'</li>';
$content.= '<li class="list-group-item"><b>Adresse</b>: '.$recup_affichage_annonce['adresse'].'</li>';
$content.= '<li class="list-group-item"><b>Code Postal</b>: '.$recup_affichage_annonce['cp'].'</li>';
$content.= '</ul>';
		
$content.='</div>
		</div>
			</div>';

}


?>



<?php
require_once('inc/haut.inc.php');
?>

<!-- dans 'href' des lien nous définissons des actions affichage -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4 bienvenu">
		<!-- si l'utilisateur est connecté; si l'utilisateur est connecté et est admin -->
			<p><?php if (userIsConnected()) { echo "<div style=\"text-align: left;\">Bienvenu sur votre profil " . $_SESSION['membre']['prenom'] . " !</div>"; } if (userIsConnectedAndIsAdmin()) { echo "<div style=\"text-align: left;\">Bienvenu sur votre profil " . $_SESSION['membre']['prenom'] . " Vous etes ADMIN !</div>"; } ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2 button">
			<a href="?action=affichage_tableau"><button type="button" class="btn btn-default">Mon Tableau de Bord</button></a>
		</div>
		<div class="col-md-2 button">
			<a href="?action=affichage_donnes"><button type="button" class="btn btn-default">Mes Données Personnelles</button></a>
		</div>
		</div>
		<!-- si l'utilisateur est connecté et est admin -->
<?phpif (userIsConnectedAndIsAdmin()) ?>		
		<div class="col-md-4 col-md-offset-8">
			<div class="row">
				<div class="col-md-12 adm">
					<h4>Gestion - Back Office</h4>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 adm">
					<a href="gestion_annonces.php?action=affichage_annonces"><button type="button" class="btn btn-default">Gestion des annonces</button></a>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 adm">
					<a href="gestion_categories.php?action=affichage_categorie"><button type="button" class="btn btn-default">Gestion des catégories</button></a>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 adm">
					<a href="gestion_membres.php?action=affichage_membres"><button type="button" class="btn btn-default">Gestion des membres</button></a>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 adm">
					<a href="gestion_commentaires.php?action=affichage_commentaires"><button type="button" class="btn btn-default">Gestion des commentaires</button></a>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 adm">
					<a href="gestion_notes.php?action=affichage_notes"><button type="button" class="btn btn-default">Gestion des notes</button></a>	
				</div>
			</div>
		</div>
</div>

<!-- afficheage des formulaire -->
<?php echo $content; ?>

<?php 
require_once('inc/bas.inc.php');
?>


