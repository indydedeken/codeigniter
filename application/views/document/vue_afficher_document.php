<div class="container" id="annoterDocument"> 
  <br>
  <br>
  <div class="annonce">
    <div class="col col-sm-4 col-md-3" id="autresDocuments">
		<div id="infoAutresDocuments">
		<h1 style="font-size:20px;">Les autres documents...</h1>
			<div id="containerMiniature">
			<!-- miniature du document choisis pour annotation -->
			<?php 
			
			/* les miniature des document perso (aux max 5 + la miniature du document choisis pour annotion)*/
				if($idGroupe == 0) 
				{
					foreach($listeDocumentsPerso->result() as $item) 
					{
					?>
                    	<a href="<?=base_url('document/afficher');?>/<?=$item->id?>/groupe/<?=$item->idGroupe?>">
							<img class="miniaturePDF" src="<?=str_replace('-html.html','.png',base_url().$item->contenuOriginal)?>" height="100" width="125"/>
                        </a>
					<?php 	
					} 
				}
				/* les miniature des document du groupe (aux max 5 + la miniature du document choisis pour annotion)*/
				else 
				{
					if($listeDocumentsGroupe->num_rows == 0) 
					{
						echo "<p>Ce document est le seul du groupe</p>";
					}
					else 
					{
						foreach($listeDocumentsGroupe->result() as $item) {
						?>
							<a href="<?=base_url('document/afficher');?>/<?=$item->idDocument?>/groupe/<?=$item->idGroupe?>">
                            	<img class="miniaturePDF" src="<?=str_replace('-html.html','.png',base_url().$item->contenuOriginal)?>" height="100" width="125" />
                            </a>
						<?php	
						}
					}
				}
			?>		
			</div>
		</div>
		<div id="infoGroupe">
			<?php foreach($groupe->result() as $item) { 
				if($item->id == 0) {
			?>
					<h1 style="font-size:20px;">Bibliothèque personnelles</h1>
					<p><span style="font-weight:bold;">-</span> <span style="color:red;"><?=$nombreDocPerso->num_rows?></span> <span style="font-weight:bold;">documents</span><p>
			<?php	}				
				else { 
			?>
					<h1 style="font-size:20px;font-weight:bold;">Le groupe <span style="font-weight:200;"><i><?=$item->intitule?></i></span></h1>
					<p><span style="font-weight:bold;">-</span> <span style="color:red;"><?=$nombreDocGroupe->num_rows?></span> <span style="font-weight:bold;">document(s)</span><p>
			<?php	foreach($nombreMembre->result() as $item) {
			?>
						<p><span style="font-weight:bold;">-</span> <span style="color:red;"><?=$item->nbMembre?></span> <span style="font-weight:bold;">participant(s)</span><p>
            <?php	}
			?>
						<p><span style="font-weight:bold;">-</span> <span style="color:red;"><?=$nombreCommentaire?></span> <span style="font-weight:bold;">commentaire(s)</span><p>
			<?php
				}	 
			}?>
			
		</div>	
    </div>
	
    
    <?php 
		$doc = $documents->result();
		$doc = $doc[0];
	?>
    <div class="justify col-sm-8 col-md-9">
		<div id="boutonsPDF">
			<div id="zoomOut"> <img style="height:40px;" src="<?=base_url()?>asset/img/zoomOut.png"> </div>
			<div id="zoomIn"> <img style="width:40px;" src="<?=base_url()?>asset/img/zoomIn.png"> </div>
			<!-- toolbox -->
			<div id="toolBox" style="display: <?php if($doc->etat == 0) echo 'none'; ?>;"> 
            	<img style="width:40px;" src="<?=base_url()?>asset/img/toolBox.png">
            </div>
            <!-- ./fin toolbox -->
            <?php
				if($estAdministrateur) 
				{
				?>
                    <div id="etat">
                        <button id="btnEtat" style="border:none;" class="btn btn-default" data-etat="<?=$doc->etat?>" <?php if($doc->etat == 2) echo "disabled";?>>
                        <?php
                            if($doc->etat == 0)
                                echo "Ouvert";
                            else if($doc->etat == 1)
                                echo "Publié";
                            else if($doc->etat == 2)
                                echo "Terminé";
                        ?> 
                        </button>
                    </div>
           	 <?php
				}
			?>
			<div id="bas"> <img style="width:40px;" src="<?=base_url()?>asset/img/bas.png"> </div>
			<span> 1 / 2 </span>
			<div id="haut"> <img style="width:40px;" src="<?=base_url()?>asset/img/haut.png"> </div>
		</div>
		<div id="panel">
			<div id="comment"> <img style="height:40px;" src="<?=base_url()?>asset/img/comment.png"> </div>
			<div id="pencil"> <img style="height:40px;" src="<?=base_url()?>asset/img/pencil.png"> </div>
			<div class="imagebutton" id="hilitecolor"><img class="image" src="<?=base_url()?>asset/img/surligner.png" ></div>
			<iframe width="250" height="170" id="colorpalette" src="<?=base_url()?>/colors.html" style="visibility:hidden; position: absolute;"></iframe>
		</div>
      	<div class="bloc_groupe"
		<!-- affichage des informations du document -->
			<iframe id="edit" src="<?=base_url().$doc->contenuOriginal?>"> </iframe>	
            <dl class="dl-horizontal">
			</dl>
        </div>
        <div class="bloc_groupe">
        	<h2>Espace de partage <button id="openComment" class="btn btn-info" type="button"><span class="glyphicon glyphicon-plus"></span></button></h2>
            <div id="nouveauCommentaire" style="display:none;">
            	<form class="form-group">
                	<div class="col-md-9">
                    	<textarea id="commentaire" name="commentaire" class="form-control" placeholder="Écrire le commentaire..." style="height:35px;"></textarea>
                    </div>
                    <div class="col-md-3">
                    	<input id="soumissionAddCommentaire" type="submit" class="btn btn-success form-control" value="Commenter">
                    </div>
                </form>
            </div>
            
      		<!-- affichage des commentaires du document -->
            <div id="groupeCommentaires">
            <?php
			if(!empty($commentaires)) 
			{
				foreach($commentaires as $commentaire)
				{
				?>
					<div class="col-md-9">
                        <h5><?=$commentaire->emailUtilisateur?> - <span style="font-weight:200;">le <i><?=$commentaire->dateCreation?></i></span> </h5>
                        <p data-idCommentaire="<?=$commentaire->id?>"><?=$commentaire->commentaire?></p>
					</div>
				<?php
                }
			}
			else
			{
				?>
                <p class="amasquer">Mince, personne n'a rien partagé ici.</p>
				<?php
			}
			?>
            </div>
            <!-- ./fin affichage des commentaires du document -->
            <dl class="dl-horizontal"></dl>
        </div>
	</div>
</div>

<script>
/*
*	surligner du texte
*/
var command = "";

function Start() {
	//passe l'iframe en modifiable
	//effet secondaire : sous firefox quand on clic sur du texte dans l'iframe, on peut les contours, le deplacer et l'agrandir
	document.getElementById('edit').contentWindow.document.designMode = "on";
	
	var hilite = document.getElementById('hilitecolor');
	parent.command = hilite.id;
  
	//affiche ou cache la palette de couleur quand on click sur le bontton pour surligner
	var clicHilite = false;
	$("#hilitecolor").click(function(e) {
		if(clicHilite === false)
		{
			document.getElementById("colorpalette").style.visibility="visible";
			clicHilite = true;
			console.log(clicHilite);
		} else {
			document.getElementById("colorpalette").style.visibility="hidden";
			clicHilite = false;
			console.log(clicHilite);
		}
	});
}
// charge la fonction start() au chargement de la page
window.onload=Start;
/* Fin surligner du texte*/

/*
*	zoomer le contenue de l'iframe
*/

// au chargment de l'iframe on ajouter la valeur zoom = 100% a la balise html
$('#edit').load(function(e) {
	//console.log(this);
	var iframeContent = this.contentWindow.document.childNodes[1];
	//pour chrome
	iframeContent.style.zoom = "100%"; 
	// pour firefox
	iframeContent.style.MozTransform = "scale(1)";
	iframeContent.style.MozTransformOrigin= "0 0";
	console.log(iframeContent);
});

$("#zoomOut").click(function(e) {
	// on défnie la valeur du dezoom
	var dezoom = 10; //chrome
	var dezoomFF = 0.1; //FireFox
	
	// on recupere la valeur actuel du zoom
	var iframeContent = document.getElementById('edit').contentWindow.document.childNodes[1];
	//pour chrome
	var zoomValue = parseInt(iframeContent.style.zoom);
	//pour firefox
	var scaleFF = iframeContent.style.MozTransform; //retourn scale(un nombre), on ne veut que le nombre
	var valuesFF = scaleFF.split('(')[1];
	valuesFF = valuesFF.split(')')[0];
   
	//la valeur final du zoom apres le click
	var zoomFinal = zoomValue - dezoom+"%"; //pour chrome
	var zoomFinalFF = valuesFF - dezoomFF; //pour firefox
	
	//on modifie la valeur actuel du zoom
	if((zoomValue - dezoom) < 10 || (zoomFinalFF < 0.1)){
		iframeContent.style.zoom = iframeContent.style.zoom; //pour chrome
		iframeContent.style.MozTransform = iframeContent.style.MozTransform; //pour firefox
	}
	else{
		iframeContent.style.zoom = zoomFinal; //pour chrome
		iframeContent.style.MozTransform = "scale("+zoomFinalFF+")"; //pour firefox
	}	
});

$("#zoomIn").click(function(e) {
	// on défnie la valeur du dezoom
	var zoom = 10; //chrome
	var zoomFF = 0.1; //FireFox
	
	// on recupere la valeur actuel du zoom
	var iframeContent = document.getElementById('edit').contentWindow.document.childNodes[1];
	//pour chrome
	var zoomValue = parseInt(iframeContent.style.zoom);
	//pour firefox
	var scaleFF = iframeContent.style.MozTransform; //retourn scale(un nombre), on ne veut que le nombre
	var valuesFF = scaleFF.split('(')[1];
	valuesFF = parseFloat(valuesFF.split(')')[0]);
   
	//la valeur final du zoom apres le click
	var zoomFinal = zoomValue + zoom+"%"; //pour chrome
	var zoomFinalFF = valuesFF + zoomFF; //pour firefox

	iframeContent.style.zoom = zoomFinal; //pour chrome
	iframeContent.style.MozTransform = "scale("+zoomFinalFF+")"; //pour firefox
		
});

/* fin du zoom */

</script>	

<script type="application/javascript">
	/*
	* afficher panel lorsqu'on clic sur #toolBox
	*/
	var clicked = false;
	
	$('#toolBox').click(function(e) {
		if(clicked === false)
		{
			$(this).css("border", "2px solid #B2DFFF");
			clicked = true;
		} else {
			$(this).css("border", "2px solid #DEDEDE");
			clicked = false;
		}	
	});
	
	/*
	 * 
	 */
	$('#toolBox').click(function() {
		$('#panel').toggle("slow");
	});
	
	$('#openComment').click(function() {
		$('#nouveauCommentaire').toggle("slow");
		$('#commentaire').focus();
	});
	
	<!-- AJAX - changer etat document
	$('#btnEtat').click(function() {
		var form_data = {
			doc		: '<?=$doc->id?>',
			etat	: $('#btnEtat').attr('data-etat'),
			ajax	: '1'
		};
		$.ajax({
			url: "<?=site_url('document/change_etat_document'); ?>",
			type: 'POST',
			async : true,
			dataType: "json",
			data: form_data,
			success: function(data) {
				// /!\ laisser le mot "erreur" dans msg pour afficher la bonne notification 
				if (/rreur/.test(data.status)) {
				  generateError(data.msg);	 
				} else {
					generateSuccess(data.msg);
					if($('#btnEtat').attr('data-etat') == 0)
					{
						$('#btnEtat').attr('data-etat', 1);
						$('#btnEtat').html('Publié'); // etat est "Publie"
						$('#toolBox').css('display', 'block');
					} 
					else if($('#btnEtat').attr('data-etat') == 1)
					{
						$('#btnEtat').attr('data-etat', 2);
						$('#btnEtat').html('Terminé'); // etat est termine
						$('#btnEtat').prop('disabled', true); // desactive le bouton "Termine"
					}
				}
			},
			error: function() {
				generateError("L'état du document ne peut plus évoluer.");
			}
		});
		return false;
	});
	<!-- ./AJAX - changer etat document
	
	<!-- AJAX - ajouter commentaire

	
	
	$('#soumissionAddCommentaire').click(function(e) {
		var idGroupe = <?=$idGroupe?>;
		e.preventDefault();
		var form_data = {
			doc			: '<?=$doc->id?>',
			grp			: '<?=$idGroupe?>',
			commentaire	: $('#commentaire').val(),
			ajax		: '1'
		};
		
		
		$.ajax({
			url: "<?=site_url('commentaire/add'); ?>",
			type: 'POST',
			async : true,
			dataType: "json",
			data: form_data,
			success: function(data) {
				// /!\ laisser le mot "erreur" dans msg pour afficher la bonne notification 
				if (/rr/.test(data.status)) {
				  generateError(data.msg);	 
				} else {
					generateSuccess(data.msg);
					$('#commentaire').val('');
					$('.amasquer').hide();
					
					var nouveauCommentaire = '<div class="col-md-9" id="commentaire_'+data.idCommentaire+'" style="display:none;">';
                    nouveauCommentaire += '<h5>'+ data.email +' - <span style="font-weight:200;">le <i>'+data.date+'</i></span> </h5>';
                    nouveauCommentaire += '<p data-idCommentaire="'+data.idCommentaire+'">'+data.commentaire+'</p>';
					nouveauCommentaire += '</div>';
					
					$('#groupeCommentaires').prepend(nouveauCommentaire);
					
					$('#commentaire_'+data.idCommentaire).show(1000);
					
				}
			},
			error: function() {
				generateError("Commentaire non valide");
			}
		});
		return false;
		
	});
	<!-- ./AJAX - ajouter commentaire
</script>
<script type="application/javascript">
	/*
	 * Préparation des boites de notification
	 * generateAlert()
	 * generateSuccess()
	 * generateError()
	 */
	//
	function generateAlert(msg) {
		var n = noty({
			text        : msg,
			type        : 'alert',
			dismissQueue: true,
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: 7000
		});
	}
	function generateSuccess(msg) {
		var n = noty({
			text        : msg,
			type        : 'success',
			dismissQueue: true,
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: 3000
		});
	}
	//
	function generateError(msg) {
		var n = noty({
			text        : msg,
			type        : 'warning',
			dismissQueue: true,
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: 2500
		});
	}



</script>
