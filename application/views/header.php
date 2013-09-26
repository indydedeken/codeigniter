<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
<!-- IE SWAGG -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Hello !</title>

<!-- CSS -->
<link href='http://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>
<link href="<?=base_url()?>asset/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>asset/css/style.css" rel="stylesheet" type="text/css">

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
        <a class="navbar-logo" href="<?=base_url('index.php/home')?>">
        	<img id="logo" src="<?=base_url()?>/asset/img/logo.png" title="logo from http://drbl.in/bjYW"/></a>
        <a class="navbar-brand" href="<?=base_url('index.php/home')?>">Pouet</a>
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
          <li class="<?php if($nav == "home") echo 'active'?>"><a href="<?=base_url('index.php/home')?>">Home</a></li>
          <li class="<?php if($nav == "page2") echo 'active'?>"><a href="#">Link</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="presentation" class="divider"></li>
              <li><a href="#">Separated link</a></li>
              <li><a href="#">One more separated link</a></li>
            </ul>
          </li>
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
          <!--<li><a href="#">Link</a></li>-->
          <li class="dropdown <?php if($nav == "membre") echo 'active'?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Compte <b class="caret"></b></a>
            <ul class="dropdown-menu">
            <?php if($this->session->userdata('logged')):?>
              <li><a href="<?=base_url('index.php/membre')?>">Profil</a></li>
              <li><a href="<?=base_url('index.php/membre')?>">Mettre à jour</a></li>
              <li><a href="<?=base_url('index.php/membre')?>">Version Premium</a></li>
              <li role="presentation" class="divider"></li>
              <li><a href="<?=base_url('index.php/membre/logout')?>">Déconnexion</a></li>
            <?php else:?>
            	<li><a href="<?=base_url('index.php/membre')?>">Connexion</a></li></li>
            <?php endif;?>
            </ul>
          </li>
        </ul>
        <form class="navbar-form navbar-right" role="search">
          <div class="form-group">
            <input type="search" class="form-control" placeholder="Bonjour...">
          </div>
          <button type="submit" class="btn btn-default">go</button>
        </form>
      </div><!-- /.navbar-collapse -->
    </nav>
</header>