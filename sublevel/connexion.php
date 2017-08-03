<?php 
require_once("inc/init.inc.php");//on inclue le doc init

if(isset($_GET['action']) && $_GET['action'] == 'deconnexion') {//lorsque nous clickons sur le lien 'deconnaixion'

	unset($_SESSION['membre']);//nous  supprimons le membre de la session

}


if(userIsConnected()) {//nous vérifions si l'utilisateur est connecté

	header('location:profil.php');//si oui bous le rédirigeons sur la page d'accueil
	exit();//et nous arretons le traitement du reste du code
}

if(!empty($_POST)) {

	$r = $pdo->query("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");// nous selectionnons en BDD les informations de l'internaute qui tente de saisr un pseudo

	if($r->rowCount() >= 1) {// nous comptons le nombre de résultats de la requete select, si il y a au moins 1 resultat, c'est qu'un pseudo de la BDD correspond bien au pseudo du formulaire
	
		$membre = $r->fetch(PDO::FETCH_ASSOC); // on transforme le resultat en tableau ARRAY, nous avons donc dans ce tableau toute les infos de l'internaute qui a saise le bon pseudo
		//password_verify($_POST['mdp'], $membre['mdp'] // fonctionne pour decrypter les mots de passe hacher

		if(password_hash($_POST['mdp'], PASSWORD_DEFAULT, array('salt' => $membre['salt'])) == $membre['mot_de_passe']) {// on compare le mot de passe saisie dans le formulaire avec celui selectionné en BDD
		// nous rentrons ici seulement si les mots de passe correspondent
			// var_dump($_POST['mdp']);

			$content .= '<div class="validation">Mot de passe connu!</div>' ;
			$_SESSION['membre']['id_membre'] = $membre['id_membre']; // on crée un espace à l'intérieur du fichier session et enregistrons les informations lié à cet internaute
			$_SESSION['membre']['pseudo'] = $membre['pseudo'];
			$_SESSION['membre']['mot_de_passe'] = $membre['mot_de_passe'];
			$_SESSION['membre']['nom'] = $membre['nom'];
			$_SESSION['membre']['prenom'] = $membre['prenom'];
			$_SESSION['membre']['telephone'] = $membre['telephone'];
			$_SESSION['membre']['email'] = $membre['email'];
			$_SESSION['membre']['civilite'] = $membre['civilite'];
			$_SESSION['membre']['statut'] = $membre['statut'];
			$_SESSION['membre']['date_enregistrement'] = $membre['date_enregistrement'];
			//debug($_SESSION);			
			header("location:profil.php"); // une fois connécté, nous redirigeons l'internaute vers sa page profil	

		} else {

			$content .= '<div>Erreur de mot de passe!</div>';//sinon une erreur de mode passe

		}
	} else {

		$content .= '<div>Erreur de pseudo!</div>';//sinon erreur de pseudo

	}
}


require_once('inc/haut.inc.php');//on appelle la partie haut de la page
?>

<!-- AFFICHAGE DU FORMULAIRE -->
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form action="" method="POST">
				<div class="form-group form-head">
				    <h2>Se connecter</h2>
			  	</div>
				<div class="form-group">
				    <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudo">
			  	</div>
			  	<div class="form-group">
				    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Votre mot de passe">
			  	</div>
			  	<button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
			  	<div class="form-group form-head">
				    <a href="<?php echo URL; ?>sublevel/inscription.php">Sinon, inscrivez-vous</a>
			  	</div>
			</form>
			<?php if(!empty($content)) {echo "<div class=\"alert alert-danger\">$content</div>";} ?>
		</div>
	</div>
</div>


<?php 
require_once('inc/bas.inc.php');//on appelle la partie bas de la page
?>
