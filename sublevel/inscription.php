<?php 
require_once("inc/init.inc.php");//on inclue le doc init


//-------------VERIFICATION DES DONNEES DU FORMULAIRE---------------//
if (!empty($_POST)) {//on vérifie si POST n'est pas vide pour éviter l'affichage des erreurs

	foreach ($_POST as $key => $value) {//pour éviter des injections sql

		$value=htmlspecialchars(addslashes($value));

	}

	if (strlen($_POST['pseudo'])<1 || strlen($_POST['pseudo'])>20) {

		$content.='<div class="">Le nombre de charactères de pseudo doit etre entre 1 et 20</div>';

	}

	if (!preg_match('/^[a-zA-Z0-9-_.]+$/', $_POST['pseudo'])) {

		$content.='<div class="">Le pseudo ne peut pas contenir des charactères differents de littres, chiffres et - ou _ ou .</div>';
	}

	if (strlen($_POST['mdp'])<5) {

		$content.='<div class="">Le nombre de charactères de mot de passe ne peut pas etre inférieur à 5</div>';

	}

	if (strlen($_POST['nom'])<1 || strlen($_POST['nom'])>20) {

		$content.='<div class="">Le nombre de charactères de nom doit etre entre 1 et 20</div>';

	}

	if (!preg_match('/^[a-zA-Z0-9-_.]+$/', $_POST['nom'])) {

		$content.='<div class="">Le nom ne peut pas contenir des charactères differents de littres, chiffres et - ou _ ou .</div>';

	}

	if (strlen($_POST['prenom'])<1 || strlen($_POST['nom'])>20) {

		$content.='<div class="">Le nombre de charactères de prenom doit etre entre 1 et 20</div>';

	}

	if (!preg_match('/^[a-zA-Z0-9-_.]+$/', $_POST['prenom'])) {

		$content.='<div class="">Le prenom ne peut pas contenir des charactères differents de littres, chiffres et - ou _ ou .</div>';

	}

	if (strlen($_POST['telephone'])<1 || strlen($_POST['telephone'])>20) {

		$content.='<div class="">Le nombre de charactères de nom doit etre entre 1 et 20</div>';

	}

	if (!preg_match('/^[0-9]+$/', $_POST['telephone'])) {

		$content.='<div class="">Le numéro de téléphone ne peut contenir que des chiffres</div>';

	}

	$ext = array('yopmail.com', 'mailinator.com');
	$email_tab = explode('@', $_POST['email']);

	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && in_array($ext, $email_tab)) {

		$content.='<div class="">Le format d\'email n\'est pas valide</div>';

	}

	$pseudo=$pdo->query("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");

	if ($pseudo->rowCount()>=1) {

		$content .= '<div class="erreur">Le pseudo est déjà utilisé !</div>';

	}

	if (empty($content)) {//si le formulaire ne contient pas d'erreurs nous inserons le membre dans la BDD

		$signin=$pdo->prepare("INSERT INTO membre (pseudo, mot_de_passe, salt, nom, prenom, telephone, email, civilite) VALUES(:pseudo, :mot_de_passe, :salt, :nom, :prenom, :telephone, :email, :civilite)");
		$salt = md5(time().rand(1111111111111,9999999999999).'planinata');
		$password=password_hash($_POST['mdp'], PASSWORD_DEFAULT, array('salt' => $salt));

		$signin->bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
		$signin->bindParam(':mot_de_passe', $password, PDO::PARAM_STR);
		$signin->bindParam(':salt', $salt, PDO::PARAM_STR);
		$signin->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
		$signin->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
		$signin->bindParam(':telephone', $_POST['telephone'], PDO::PARAM_INT);
		$signin->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
		$signin->bindParam(':civilite', $_POST['civilite'], PDO::PARAM_STR);

	if($signin->execute()) {//on crée la session pour ce membre

		$session=$pdo->query("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");

		$membre=$session->fetch(PDO::FETCH_ASSOC);

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

		header('Location: http://localhost/annonceo/sublevel/profil.php');
	}
		
	}
}


//--------AFFICHAGE DU FORMULAIRE-------------//
require_once('inc/haut.inc.php');//partie haute de la page
?>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<form action="" method="POST">
				<div class="form-group form-head">
				    <h2>S'inscrire</h2>
			  	</div>
				<div class="form-group">
				    <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudo">
			  	</div>
			  	<div class="form-group">
				    <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Votre mot de passe">
			  	</div>
			  	<div class="form-group">
				    <input type="text" class="form-control" name="nom" id="nom" placeholder="Votre nom">
			  	</div>
			  	<div class="form-group">
				    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Votre prenom">
			  	</div>
			  	<div class="form-group">
				    <input type="email" class="form-control" name="email" id="email" placeholder="Votre email">
			  	</div>
			  	<div class="form-group">
				    <input type="text" class="form-control" name="telephone" id="telephone" placeholder="Votre téléphone">
			  	</div>
			  	<div class="form-group">
				    <select name="civilite" class="form-control">
					  <option value="m">Homme</option>
					  <option value="f">Femme</option>
					</select>
			  	</div>
			  	<button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
			  	<div class="form-group form-head">
				    <a href="<?php echo URL; ?>sublevel/connexion.php">Sinon, connectez-vous</a>
			  	</div>
			</form>
			<?php if(!empty($content)) {echo "<div class=\"alert alert-danger\">$content</div>";} ?>
		</div>
	

	</div>
</div>


<?php 
require_once('inc/bas.inc.php');//partie basse de la page
?>