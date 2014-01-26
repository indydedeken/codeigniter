<div class="container"> 
  <br>
  <br>
  <div id="finDePage" class="row annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Mon groupe</h1>
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_groupe">
      		<!-- affichage des informations du groupe -->
            <dl class="dl-horizontal">
            <?php 
				foreach($groupe->result() as $item) { ?>
                	<h2>Groupe : <?=$item->intitule?></h2>
					<dt>Création</dt><dd><?=$item->dateCreation?></dd>
					<dt>Description</dt><dd><?=$item->description?></dd><br>
					<div class="btn-group" style="width:100%">
						<button id="quitGroupe" class="btn btn-default btn-primary" type="button" style="width:22%">Quitter</button>
						<?php if($estAdministrateur): ?>
							<button id="editGroupe" class="btn btn-default btn-primary" type="button" style="width:22%">Éditer</button>
							<button id="delGroupe" class="btn btn-default btn-danger" type="button" style="width:22%">Supprimer</button>
						<?php endif;?>
			        </div>
			<?php } ?>
			</dl>
        </div>
        <div class="bloc_profil_infoPerso">
        	<table class="table table-hover">
            	<tr>
                	<th>Titre</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Etat</th>
                </tr>
				<?php foreach($documents->result() as $item) { ?>
                    <tr id="document_<?php echo $item->idDocument; ?>" <?php if($item->etat == 2) echo 'class="danger"'; ?>>
                        <td><?=$item->titre?></td>
                        <td><?=$item->auteur?></td>
                        <td><?=$item->dateCreation?></td>
                        <td><?=$item->libelle?></td>
                    </tr>
                <?php } ?>
			</table>
        </div>   
        <div>
        	<!-- affichage des membres du groupe -->
        	<dl class="dl-horizontal">
	        	<dt>Membres</dt>
		        	<?php 
						foreach($membresGroupe->result() as $item) { ?>
		                	<dd><?=ucfirst($item->prenom)?> <?=ucfirst($item->nom)?> (<?=$item->emailUtilisateur?>)</dd>
					<?php } ?>
        </div>
	</div>
</div>
<script type="application/javascript">
	$(document).ready(function() {
		$('#quitGroupe').click(function() {
			var form_data = {
				email : '<?=$this->session->userdata("email")?>',
				groupe : '<?=$idGroupe?>',
				ajax : 	'1'
			};
			$.ajax({
				url: "<?=site_url('groupe/ajax_quitte_groupe'); ?>",
				type: 'POST',
				async : true,
				data: form_data,
				success: function(msg) {
					// /!\ laisser le mot "erreur" dans msg pour afficher la bonne notification 
					if (/rreur/.test(msg)) {
					  generateError(msg);	 
					} else {
						generateSuccess(msg);	
						$(document).one('click', function(){
							// décrémenter la bulle
							$('#groupe-badge').html($('#groupe-badge').text()-1);
							// modifier l'id du bouton pour stopper l'action de quitter
							$('#groupe-badge').attr("id", "groupe-badge-ok");
							$("button, input").attr("disabled", true);
							var direction = 'window.location.replace("<?php echo base_url('groupe/gestion');?>");';
							setTimeout(direction, 3000); 
						}).trigger('click'); // simuler click pour décrémenter la variable
					}
				},
				error: function() {
					generateError('Une erreur s\'est produite.<br>Impossible de terminer la requête.');
				}
			});
			return false;
		});
	});
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
