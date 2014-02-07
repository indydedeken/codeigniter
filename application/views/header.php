<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
<!-- IE SWAGG -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Markus - Outils d'annotation de pdf</title>
<script src="<?=base_url()?>asset/js/jquery-1.10.2.min.js"></script>
<script src="<?=base_url()?>asset/js/jquery-ui-1.10.4.custom.min.js"></script> 
<script src="<?=base_url()?>asset/js/jquery.noty.packaged.min.js"></script> 
<script src="<?=base_url()?>asset/js/dataTables.js"></script>

<!-- CSS -->
<link href="<?=base_url()?>asset/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>asset/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>asset/css/style.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>asset/css/jquery.pageslide.css" rel="stylesheet" type="text/css">


<!-- Favicons -->
<link rel="shortcut icon" href="<?=base_url()?>/asset/ico/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="<?=base_url()?>/asset/ico/apple-touch-icon.png" />
<link rel="apple-touch-icon" sizes="57x57" href="<?=base_url()?>/asset/ico/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon" sizes="60x60" href="<?=base_url()?>/asset/ico/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>/asset/ico/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>/asset/ico/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>/asset/ico/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon" sizes="120x120" href="<?=base_url()?>/asset/ico/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon" sizes="144x144" href="<?=base_url()?>/asset/ico/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon" sizes="152x152" href="<?=base_url()?>/asset/ico/apple-touch-icon-152x152.png" />

</head>
<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-logo" href="<?=base_url('home')?>">
        	<img id="logo" src="<?=base_url()?>/asset/img/logo.png" title="logo from http://drbl.in/bjYW"/></a>
        <a class="navbar-brand" href="<?=base_url('home')?>">Markus</a>
      </div>
    
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
      
      	<?php
			$nav = $this->uri->segment(1);
			if($nav === FALSE || $nav == ""):
				$nav = "home";
			endif;
		?>
      	
        <ul class="nav navbar-nav">
        	<li class="<?php if($this->uri->segment(1) == "home") echo 'active'?>"><a href="<?=base_url('home')?>">Home</a></li>
          	<li class="<?php if($this->uri->segment(1) == "document") echo 'active'?> dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Documents<span id="document-badge" class="badge pull-left"><?php if($this->session->userdata('nbDocumentsUtilisateur'))echo $this->session->userdata('nbDocumentsUtilisateur')?></span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if($this->session->userdata('logged')):?>
                    <?php 
					foreach($_SESSION['listeTopDocuments'] as $item) {
					?>
						<li><a href="<?=base_url('document').'/afficher/' . $item->id . '/groupe/' . $item->idGroupe?>"><?=$item->intitule?> - <?=$item->titre?></a></li>
					<?php	
					}
					?>
                    <li role="presentation" class="divider"></li>                  	
                    <li><a href="<?=base_url('document')?>">Gestion de mes documents</a></li>
                    <li><a href="#">Uploader un document</a></li>
                    <?php else:?>
                        <li><a href="<?=base_url('membre')?>">Connexion</a></li></li>
                    <?php endif;?>
                </ul>
            </li>
            <li class="<?php if($this->uri->segment(1) == "groupe") echo 'active'?> dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Groupes<span id="groupe-badge" class=" badge pull-left"><?php if($this->session->userdata('nbGroupesUtilisateur'))echo $this->session->userdata('nbGroupesUtilisateur')?></span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php if($this->session->userdata('logged')):?>
                    <?php 
					foreach($_SESSION['listeTopGroupes'] as $item) {
					?>
						<li><a href="<?=base_url('groupe').'/afficher/' . $item->idGroupe?>"><?=$item->intitule?></a></li>
					<?php	
					}
					?>
                    <li role="presentation" class="divider"></li>
                    <li><a href="<?=base_url('groupe')?>">Gestion de mes groupes</a></li>
                    <li><a href="<?=base_url('groupe/creer')?>">Créer un groupe</a></li>
                    <?php else:?>
                        <li><a href="<?=base_url('membre')?>">Connexion</a></li></li>
                    <?php endif;?>
                </ul>
            </li>
        </ul>
       	
        <ul class="nav navbar-nav navbar-right">
          <!--<li><a href="#">Link</a></li>-->
          <li class="dropdown <?php if($this->uri->segment(1) == "membre") echo 'active'?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Compte <b class="caret"></b></a>
            <ul class="dropdown-menu">
            <?php if($this->session->userdata('logged')):?>
              <li><a href="<?=base_url('membre')?>/profil">Profil <?=$this->session->userdata('email')?></a></li>
              <li><a href="<?=base_url('membre')?>">Mettre à jour</a></li>
              <li><a href="<?=base_url('membre')?>">Uploader un document</a></li>
              <li role="presentation" class="divider"></li>
              <li><a href="<?=base_url('membre/logout')?>">Déconnexion</a></li>
            <?php else:?>
            	<li><a href="<?=base_url('membre')?>">Connexion</a></li></li>
            <?php endif;?>
            </ul>
          </li>
        </ul>
        <form class="navbar-form navbar-right" role="search">
          <div class="form-group">
            <input type="search" class="form-control" placeholder="chercher un groupe..." spellcheck="true">
          </div>
          <?php /* Voir si la saisie de la touche "entrée" peut valider la recherche ?>
		  <button type="submit" class="btn btn-default">go</button>
		  <?php */?>
        </form>
      </div><!-- /.navbar-collapse -->
    </nav>
</header>