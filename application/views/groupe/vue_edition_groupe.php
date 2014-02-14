<div id="editionGroupe" class="justify col-sm-8 col-md-9">
	<?php 
	foreach($groupe->result() as $item) { 
	?>
	<!--<a href="<?=base_url('groupe').'/afficher/' . $item->id ?>" style="float:right;">
		<button type="button" class="btn btn-xs">Retour</button>
	</a>-->
	<br>
	<br>
	<form method="POST" id="formEditGroupe" class="form-horizontal" role="form">
		<div class="form-group">
			<input type="hidden" id="idGroupe" value="<?=$item->id?>" disabled/>
			<div class="form-group">
				<label class="col-md-3 control-label">Nom du groupe</label>
				<div class="col-md-9">
					<input type="text" id="intitule" nom="intitule" class="form-control" value="<?=$item->intitule?>"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Description</label>
				<div class="col-md-9">
					<textarea id="description" nom="description" class="form-control"><?=$item->description?>
</textarea>
				</div>
			</div>
			<div class="right">
				<a href="<?=base_url('groupe').'/afficher/' . $item->id ?>"><button type="button" class="btn btn-large btn-primary">Retour</button></a>
				<a id="recordEdit" href="#" class="btn btn-large btn-success">Enregistrer</a>
			</div>
		</div>
	</form>
	<?php
	}
	?>
</div>
<script><!--
	
	// enregistrement des données d'édition 
	$('#recordEdit').click(function(e) {
		
		var error = 0;
		
		// vérification JS pour le renseignement des champs
		if($('#idGroupe').val() == "") {
			generateError("Erreur : Le groupe est mal renseigné. Veuillez recharger la page.");
			error = 1;
		} else if($('#intitule').val() == "") {
			generateError("Erreur : Le titre du groupe est mal renseigné.");
			error = 1;
		} else if($('#description').val() == "") {
			generateError("Erreur : Le groupe doit être décrit.");
			error = 1;
		}
		
		// on annule la mise à jour des données
		if(error) {
			return false;
		}
		
		var form_data = {
			idGroupe : $('#idGroupe').val(),
			intitule : $('#intitule').val(),
			description : $('#description').val(),
			ajax : 	'1'
		};
		
		// mettre à jour les infos du groupe
		$.ajax({
			url: "<?=site_url('groupe/ajax_edit_groupe'); ?>",
			type: 'POST',
			async : true,
			data: form_data,
			success: function(msg) {
				// /!\ laisser le mot "erreur" dans msg pour afficher la bonne notification 
				if (/rreur/.test(msg)) {
					generateError(msg);	 
				} else {
					generateSuccess(msg);	
				}
			},
			error: function() {
				generateError('Une erreur s\'est produite.<br>Impossible de terminer la requête.');
			}
		});
		return false;
	});
	<!-- ./AJAX	
--></script>
