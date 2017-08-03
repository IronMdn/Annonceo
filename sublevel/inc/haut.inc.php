<!DOCTYPE html>
<html lang="FR-fr">
<head>
	<meta charset="UTF-8">
	<title>Haut-Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>sublevel/inc/css/style.css">
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a class="navbar-brand" href="<?php echo URL; ?>">Annonceo</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="info/quisommesnous.html">Qui Sommes Nous<span class="sr-only">(current)</span></a></li>
        <li><a href="info/contact.html">Contact</a></li>
      </ul>
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="#">Link</a></li>
      <li class="dropdown">
      <a  href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Espace Membre</a>
          <ul class="dropdown-menu">

          <?php if(userIsConnected() || userIsConnectedAndIsAdmin()) {
            echo '<li><a href="' . URL . '/sublevel/profil.php">Mon profil</a></li>';
            echo '<li role="separator" class="divider"></li>';
            echo '<li><a href="' . URL . '/sublevel/connexion.php?action=deconnexion">Deconnexion</a></li>';
            } else {
            echo '<li><a href="' . URL . '/sublevel/connexion.php">Connexion</a></li>';
            echo '<li><a href="' . URL . '/sublevel/inscription.php">Inscription</a></li>';
            echo '<li role="separator" class="divider"></li>';
            echo '<li><a href="' . URL . '/sublevel/connexion.php?action=deconnexion">Deconnexion</a></li>';
            }
          ?>
          
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


	

			
	


