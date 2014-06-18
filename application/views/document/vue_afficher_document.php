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
					<p><span style="font-weight:bold;">-</span> <span style="color:red;"><?=$nombreDocGroupe->num_rows?></span> <span style="font-weight:bold;">documents</span><p>
			<?php	foreach($nombreMembre->result() as $item) {
			?>
						<p><span style="font-weight:bold;">-</span> <span style="color:red;"><?=$item->nbMembre?></span> <span style="font-weight:bold;">participants</span><p>
			<?php	}	
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
			<div id="surligner"> <img style="height:40px;" src="<?=base_url()?>asset/img/surligner.png"> </div>
				<!--
				<div id="cBlack" style="background-color:black;"> </div>
				<div id="cRed" style="background-color:red;"> </div>
				<div id="cBlue" style="background-color:blue;"> </div>
				<div id="cGreen" style="background-color:green;"> </div>
				-->
		</div>
      	<div class="bloc_groupe">
      		<!-- affichage des informations du document -->
            <iframe src="<?=base_url().$doc->contenuOriginal?>" height="850px" width="100%"> </iframe>
            <dl class="dl-horizontal">
			</dl>
        </div>
        <div>
        	<!-- affichage des membres du groupe -->
        	<dl class="dl-horizontal">
            </div>
	</div>
</div>
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
			timeout		: 10000
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
			type        : 'error',
			dismissQueue: true,
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: false
		});
	}



</script>
