<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">-->
<!-- IE SWAGG -->
<!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
<title>Mark Us - Outils d'annotation de pdf</title>
<script src="<?=base_url()?>asset/js/jquery-1.10.2.min.js"></script>
<script src="<?=base_url()?>asset/js/jquery-ui-1.10.4.custom.min.js"></script> 
<script src="<?=base_url()?>asset/js/jquery.noty.packaged.min.js"></script>
<?php if($this->uri->segment(1) == "document" && $this->uri->segment(2) == "creer"): ?>
    <script type="text/javascript">
    // refresh_files permet de mettre à jour la liste des documents uploadés par l'utilisateur
    refresh_files();
	
    $(function() {
	// affichage des champs titre, auteur...
	$('input#userfile[type="file"]').on('change', function(event){ 
		$('input[type="submit"]').prop("disabled", false);
		$('#infoComplementaires').show({duration: 750, complete: saisirInfoComplementaires});
		$('input#titre').focus();
	});
	
	function saisirInfoComplementaires() {
		generateAlert("Personnalisez votre document en indiquant son titre, l'auteur...");
	}
	
	$('#uploadDocument').submit(function(e) {
	    e.preventDefault();
		generateAlert('<img src="<?=base_url()?>asset/img/chargement.gif"><br><div style="color:#F2853C; font-size:16px;"><p>Le chargement du document est en cours...</p></div>');
		
	    $.ajaxFileUpload({
		url             :'<?=base_url()?>document/upload/',
		secureuri       :false,
		fileElementId   :'userfile',
		dataType        :'json',
		data            : {
		  'titre' : $('#titre').val(),
		  'auteur' : $('#auteur').val(),
		  'description' : $('#description').val()
		},
		success : function (data, status)
		{
		    if(data.status != 'error')
		    {
			
			refresh_files();
			$('#titre').val('');
			$('#auteur').val('');
			$('#description').val('');
		    }
		    if (data.status == "success") {
			//$.noty.closeAll();
			generateSuccess(data.msg);
		    } else {
			generateError(data.msg);
			$("#userfile").val(''); // vider input type=file
		    }
		},
		error : function (data, status)
		{
		    $("#userfile").val(''); // vider input type=file
		    console.log(data);
			alert(status);
		}
	    });
	    return false;
	});
	
	$(document).on('click', '.lien_suppression_document', function(e) {
	    e.preventDefault();
	    if (confirm('En supprimant ce document, vous perdrez toutes ses annotations.\n' +
			'Êtes vous certain de vouloir perdre toutes les informations liées à ce document ?\n\n'+
			'Cette action est irréversible !!!'))
	    {
		
		var link = $(this);
		$.ajax({
		    url         : '<?=base_url()?>document/delete_file/' + link.data('file_id'),
		    dataType    : 'json',
		    success     : function (data)
		    {
				var files = $('#element'+ link.data('file_id'));
				if (data.status === "success")
				{
					files.fadeOut('slow', function() {
					$(this).remove();
					if (files.length == 0)
					{
						files.parent(div).html('<p>Aucun fichier</p>');
					}
					});
					generateSuccess(data.msg);
					//refresh_files();
				}
				else
				{
					alert(data.msg);
				}
		    }
		});
	    }
	});	
    });
    
    function refresh_files() {    
	$.get('<?=base_url()?>document/files').success(function (data) {
	    $('#files').html(data);
	});
	$("#userfile").val(''); // vider le fichier
    }
    </script>
<?php endif;?>
<script src="<?=base_url()?>asset/js/dataTables.js"></script>
<script src="<?=base_url()?>asset/js/ajaxfileupload.js"></script>

<!-- CSS -->
<link href="<?=base_url()?>asset/css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>asset/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>asset/css/style.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>asset/css/jquery.pageslide.css" rel="stylesheet" type="text/css">
<link href="<?=base_url()?>asset/css/style.css" rel="stylesheet" />

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
<script>
    $.widget(	
		"custom.catcomplete", 
		$.ui.autocomplete, 
		{
			_renderMenu: function( ul, items ) {
				var that = this, currentCategory = "";
				$.each( items, function( index, item ) {
					if ( item.category != currentCategory ) {
						ul.append( "<li class='ui-autocomplete-category' style='font-weight:bold; text-transform: capitalize; background:white;'>" + item.category + "</li>" );
						currentCategory = item.category;
					}
					that._renderItemData( ul, item );
				});
			}
		}
	);
</script>
<script>
$(function() {
	// données qui alimentent le search du header
    var data = [
	// liste des documents
	<?php
	if(isset($_SESSION['listeDocuments']) && isset($_SESSION['listeGroupes']))
	    foreach($_SESSION['listeDocuments'] as $item)
	    {
	    ?>
		{ id: "<?=$item->id?>", label: "<?=str_replace('"', '\"', $item->titre)?>", category: "document"},
		<?php	
		}
		?>
		// liste des groupes
		<?php
		foreach($_SESSION['listeGroupes'] as $item) {
		?>
		{ id: "<?=$item->id?>", label: "<?=str_replace('"', ' ', $item->intitule)?>", category: "groupe"},
		<?php	
	    }
	    ?>
    ];
	
    $("#search").catcomplete({
		delay: 0,
		minLength: 2,
		source: data,
		select: function( event, ui ) {
			// traitement de la recherche selectionnée
			$("#search").value = ui.item.label;
			$("#searchHidden")
				.attr("data-id", ui.item.id)
				.attr("data-label", ui.item.label)
				.attr("data-category", ui.item.category);
			return false;
		}
    });
});
</script>
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
        <a class="navbar-logo" href="<?=base_url()?>">
        	<img id="logo" src="<?=base_url()?>asset/img/logo.png" alt="logo" title="from http://drbl.in/bjYW"/></a>
        <a class="navbar-brand" href="<?=base_url()?>">Mark Us</a>
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
        	<li class="<?php if($this->uri->segment(1) == "home") echo 'active'?>"><a href="<?=base_url()?>">Home</a></li>
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
                    <li><a href="<?=base_url('document')?>">Mes documents</a></li>
                    <li><a href="<?=base_url('document/creer')?>">Uploader un document</a></li>
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
				<!--<li><a href="<?=base_url('groupe').'/afficher/' . $item->idGroupe?>"><?=$item->intitule?></a></li>-->
		    <?php	
		    }
		    ?>
                    <!--<li role="presentation" class="divider"></li>-->
                    <li><a href="<?=base_url('groupe').'/afficher/0';?>">Biliothèque personnelle</a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a href="<?=base_url('groupe')?>">Mes groupes</a></li>
                    <li><a href="<?=base_url('acces')?>">Les accès aux groupes</a></li>
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
              <li><a href="<?=base_url('document/creer')?>">Uploader un document</a></li>
              <li role="presentation" class="divider"></li>
              <li><a href="<?=base_url('membre/logout')?>">Déconnexion</a></li>
            <?php else:?>
            	<li><a href="<?=base_url('membre')?>">Connexion</a></li></li>
            <?php endif;?>
            </ul>
          </li>
        </ul>
        <form id="formSearch" class="navbar-form navbar-right" role="search">
          <div class="form-group">
            <input id="search" type="search" class="form-control" placeholder="chercher un groupe..." spellcheck="true" value="" autocomplete="off">
            <input id="searchHidden" type="hidden">
          </div>
          
		  <!--<button type="submit" class="btn btn-default">go</button>-->
		  
        </form>
      </div><!-- /.navbar-collapse -->
    </nav>
</header>