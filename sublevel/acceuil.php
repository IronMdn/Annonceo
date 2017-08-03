<?php
require_once("inc/init.inc.php");


//------------------RECUPERATION DES DONNES POUR LA PARTIE DE GAUCHES(CATHEGORIES, PAYS, MEMBRE)-------------//
$show_me_cats=$pdo->prepare("SELECT titre FROM categorie");
$show_me_cats->execute();
$cats=$show_me_cats->fetchAll();

$show_me_countries=$pdo->prepare("SELECT DISTINCT pays FROM annonce");
$show_me_countries->execute();
$annonce=$show_me_countries->fetchAll();

$show_me_users=$pdo->prepare("SELECT pseudo FROM membre");
$show_me_users->execute();
$users=$show_me_users->fetchAll();

//------------------------AFFICHAGE DES ANNONCES DANS LA PARTIE DROITE-----------------------//
$req = "SELECT a.titre, a.description_courte, a.prix, a.photo, m.pseudo
FROM annonce a, membre m, categorie c
WHERE a.id_membre=m.id_membre
AND a.id_categorie=c.id_categorie";

//---------------------FILTRE DES ANNOCEs-------------------//(le menu sur la gauche de la page)	
if(!empty($_POST)) {

	// var_dump($_POST);

	foreach($_POST as $key => $value){

		if(!empty($value)){

			if($key == 'categorie'){

				$req .= " AND a.id_categorie=c.id_categorie AND c.titre = '$value'";
			}

			elseif($key == 'prix'){

				$req .= " AND a.prix <= $value";

			}

			elseif($key == 'membre'){

				$req .= " AND a.id_membre=m.id_membre AND m.pseudo = '$value'";
			}

			elseif($key == 'pays') {

				$req .= " AND a.pays = '$value'";

			}
		}
	}
}

if (!empty($_POST['range'])) {

	// var_dump($_POST['range']);
	if($_POST['range']==='price_up') {

		$req .= " ORDER BY a.prix ASC LIMIT 0,10";

	}

	if($_POST['range']==='price_down') {

		$req .= " ORDER BY a.prix DESC LIMIT 0,10";

	}

	if($_POST['range']==='date_old-first') {

		$req .= " ORDER BY a.date_enregistrement ASC LIMIT 0,10";

	}

	if($_POST['range']==='date_recent-first') {

		$req .= " ORDER BY a.date_enregistrement DESC LIMIT 0,10";
		
	}	
}

// echo '<hr/>';
// echo $req;
// echo '<hr/>';

$show_me_last=$pdo->prepare($req);
$show_me_last->execute();
$result=$show_me_last->fetchAll(PDO::FETCH_ASSOC);	

// echo '<pre>';
// print_r($result);
// echo '</pre>';

?>

<div class="container">
	<div class="row">
	<!--                AFFICHANGE DES CRITERES DE SELECTIONS         -->
		<div class="col-md-3">
		<form action="" method="POST">
			<div class="form-group">
				<label for="categorie">Catégorie</label>
    			<select id="categorie" name="categorie" class="form-control">
    			<option value="">Tous les catégories</option>
    			<?php
    			foreach ($cats as $key => $value) {
    				echo '<option value="'.$value['titre'].'"'; if(!empty($_POST['categorie']) && $_POST['categorie']===$value['titre']) {echo ' selected';} echo '>'.$value['titre'].'</option>';
    			}
    			?>		  
				</select>
			</div>
			<div class="form-group">
				<label for="pays">Pays</label>
    			<select id="pays" name="pays" class="form-control">
    			<option value="">Tous les pays</option>
    			<?php  
    			foreach ($annonce as $key => $value) {
    				echo '<option value="'.$value['pays'].'"'; if(!empty($_POST['pays']) && $_POST['pays']===$value['pays']) {echo ' selected';} echo '>'.$value['pays'].'</option>';
    			}
    			?>		  
				</select>
			</div>
			<div class="form-group">
				<label for="membre">Membre</label>
    			<select id="membre" name="membre" class="form-control">
    			<option value="">Tous les membres</option>
    			<?php  
    			foreach ($users as $key => $value) {
    				echo '<option value="'.$value['pseudo'].'"'; if(!empty($_POST['membre']) && $_POST['membre']===$value['pseudo']) {echo ' selected';} echo '>'.$value['pseudo'].'</option>';
    			}
    			?>		  
				</select>
			</div>
			<div class="form-group">
				<label for="prix">Prix max</label>
				<input type="text" name="prix" id="prix" placeholder="prix max" class="form-control" value="<?php if(!empty($_POST['prix'])) {echo $_POST['prix'];} ?>">
			</div>
			<button type="submit" class="btn btn-default">Valider</button>
		</form>					
		</div>
		<div class="col-md-1">
		</div>
		<div class="col-md-8">
			<div class="row">
			<!--                AFFICHANGE DES CRITERES DE TRIAGE          -->
			<form action="" method="POST">
				<div class="col-md-6">
    				<select name="range" class="form-control">
    					<option value="price_up"<?php if(isset($_POST['range']) && $_POST['range']==='price_up') {echo ' selected';} ?>>Trier par prix (du moins cher au plus cher)</option>
    					<option value="price_down"<?php if(isset($_POST['range']) && $_POST['range']==='price_down') {echo ' selected';} ?>>Trier par prix (du plus cher au moins cher)</option>
    					<option value="date_old-first"<?php if(isset($_POST['range']) && $_POST['range']==='date_old-first') {echo ' selected';} ?>>Trier par date (de la plus ancienne à la plus récente)</option>
    					<option value="date_recent-first"<?php if(isset($_POST['range']) && $_POST['range']==='date_recent_first') {echo ' selected';} ?>>Trier par date (de la plus récente à la plus ancienne)</option>
    				</select> 
				</div>
				<div class="col-md-6">
					<button type="submit" class="btn btn-default">Valider</button>
				</div>
			</form>		
			</div>
			<hr>
<!--                AFFICHANGE DES ANNONCES          -->		
			<?php if($show_me_last -> rowCount() > 0) : ?>
				<?php for($i = 0; $i < count($result); $i ++) : ?>

				<div class="row">
					<div class="col-md-4">	
						<img height="120px" width="180px" src="<?php echo $result[$i]['photo'];?>" alt="image_annonce">
					</div>
					<div class="col-md-8">	
						<h4><a  href="#"><?php echo $result[$i]['titre']; ?></a></h4>
							<p><?php echo $result[$i]['description_courte']; ?></p>
					<div class="row">
						<div class="col-md-10">
							<a href="#"><?php echo $result[$i]['pseudo'];?></a><span>*******</span>
						</div>
						<div class="col-md-2">
							<span><?php echo $result[$i]['prix'].'€'; ?></span>
						</div>
					</div>
					</div>									
				</div>
				<hr>

				<?php endfor; ?>
			<?php else: ?>
				<p style="color: red">Aucun résultat !! </p>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-12 voir-plus">
					<a href="#">Voir plus</a>
				</div>
			</div>
		</div>
	</div>
</div>