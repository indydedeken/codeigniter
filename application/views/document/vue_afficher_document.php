<div class="container" id="annoterDocument"> 
  <br>
  <br>
  <div class="annonce">
    <div class="col col-sm-4 col-md-3" id="autresDocuments">
		<div id="infoAutresDocuments">
		<h1>Document</h1>
			<div id="containerMiniature">
			<!-- miniature du document choisis pour annotation -->
			<?php 
			foreach($documents->result() as $item) { ?>
						<img class="miniaturePDF" src="<?=str_replace('-html.html','.png',base_url().$item->contenuOriginal)?>" height="150" width="200"> </img>
				<?php } ?>	
			<?php 
			/* les miniature des document perso (aux max 5 + la miniature du document choisis pour annotion)*/
				if($idGroupe == 0) {
					foreach($listeDocumentsPerso->result() as $item) {?>
						<img class="miniaturePDF" src="<?=str_replace('-html.html','.png',base_url().$item->contenuOriginal)?>" height="150" width="200"> </img>
			<?php 	} 
				}
				/* les miniature des document du groupe (aux max 5 + la miniature du document choisis pour annotion)*/
				else {
					foreach($listeDocumentsGroupe->result() as $item) {	?>
						<img class="miniaturePDF" src="<?=str_replace('-html.html','.png',base_url().$item->contenuOriginal)?>" height="150" width="200"> </img>
			<?php	}
				}	?>		
			</div>
		</div>
		<div id="infoGroupe">
			<?php foreach($groupe->result() as $item) { 
				if($item->id == 0) {
			?>
					<h1>Bibliothèque personnelles</h1>
			<?php
					$countNombreDocPerso = 0;
					foreach($nombreDocPerso->result() as $item) {
							$countNombreDocPerso++;
					} ?>
					<p>- <span style="color:red;"><?=$countNombreDocPerso?></span> documents<p>
			<?php	}				
				else { ?>
					<h1><?=$item->intitule?></h1>
			<?php	
					$countNombreDocGroupe = 0;
					foreach($nombreDocGroupe->result() as $item) {
							$countNombreDocGroupe++;
					} ?>
						<p>- <span style="color:red;"><?=$countNombreDocGroupe?></span> documents<p>
			<?php	foreach($nombreMembre->result() as $item) {?>
						<p>- <span style="color:red;"><?=$item->nbMembre?></span> membres<p>
			<?php	}	
				}	 
			}?>
			
		</div>	
    </div>
	
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_groupe">
      		<!-- affichage des informations du document -->
			<?php foreach($documents->result() as $item) { ?>
                	<iframe src="<?=base_url().$item->contenuOriginal?>" height="850px" width="100%"> </iframe>
					
			<?php } ?>
			
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
