<div class="container">
	<div id="" class="annonce">
		<div class="col col-sm-4 col-md-3">
			<h1>Uploader un document</h1>
		</div>
		<div class="justify col-sm-8 col-md-9">
			<?php echo form_open_multipart('document/upload', 'class="form-horizontal" role="form"');?>
			<div class="form-group">
				<input type="file" id="userfile" name="userfile" size="20" />
			</div>
			<div id="infoComplementaires" style="display: none;">
				<div class="form-group">
					<label class="col-md-3 control-label">Titre du document</label>
					<div class="col-md-9">
						<input id="titre" type="texte" name="titre" class="form-control" placeholder="Titre visible du document">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Auteur</label>
					<div class="col-md-9">
						<input id="auteur" type="texte" name="auteur" class="form-control" placeholder="Le ou les auteurs">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Description</label>
					<div class="col-md-9">
						<textarea name="description" style="max-width:100%;" class="form-control" placeholder="Synthèse du document"></textarea>
					</div>
				</div>
			</div>
			<br />
			<input type="submit" class="btn btn-lg btn-success" style="width:100%;" value="upload" />
			</form>
		</div>
	</div>
</div>
<script type="application/javascript"><!--
	$(document).ready(function() {
		$('#creationGroupe').submit(function(e){
			if($('#creationGroupe #nom').val() == '') {
				generateError('Votre groupe ne porte pas de nom.');
				return false;
			} else 
				return true;
		});
	});
	
	// affichage des champs titre, auteur...
	$('input#userfile[type="file"]').on('change', function(event){ 
		$('input[type="submit"]').prop("disabled", false);
		$('#infoComplementaires').show({duration: 750, complete: saisirInfoComplementaires});
		$('input#titre').focus();
		
	});
	
	function saisirInfoComplementaires() {
		generateAlert("Personnalisez votre document en indiquant son titre, l'auteur...");
	}
--></script> 
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
			layout      : 'top',
			theme       : 'defaultTheme',
			killer		: true,
			maxVisible	: 1,
			timeout		: 10000,
			callback: {
				onShow: function() {},
				afterShow: function() {},
				onClose: function() {},
				afterClose: function() {$('#nom').focus();}
			}	
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
			layout      : 'top',
			theme       : 'defaultTheme',
			killer		: true,
			maxVisible	: 1,
			timeout		: 3000,
			callback: {
				onShow: function() {$('#nom').focus();},
				afterShow: function() {},
				onClose: function() {$('#nom').focus();},
				afterClose: function() {}
			}	
		});
	}
</script>
