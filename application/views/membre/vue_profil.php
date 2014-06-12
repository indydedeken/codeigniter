<div class="container"> 
<br>
  <br>
  
  <div id="blocContent" class="row annonce">
    <div class="col col-sm-3 col-md-2">
      <h1>Profil</h1>
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_profil_infoPerso">
            <h2>Mes informations</h2>
            <?=form_open('membre/profil')?>
            <div class="libelle">Nom</div>
            <div class="valeur"><?=form_input(array('id'=>'nom', 'name'=>'nom','value'=>$this->session->userdata('nom'),'class'=>'form-control','style'=>''))?></div>
            <div class="libelle">Prénom</div>
            <div class="valeur"><?=form_input(array('id'=>'prenom', 'name'=>'prenom','value'=>$this->session->userdata('prenom'),'class'=>'form-control','style'=>''))?></div>
			<br>
            <div>
			<?=form_submit('submit','Éditer','id="submit" class="btn btn-lg btn-success" style="width:300px"')?></div>
			<?=form_close()?>
        </div>
	
        <!-- affichage des documents de l'utilisateur -->
        <h2>Mes documents</h2>
        <?php
	  foreach($annotationGrp as $annotation)
	  {
	    //echo $annotation->dateCreation;
	    if($annotation->idTypeAnnotation == 1)
	      $action = 'commenter';
	    else if($annotation->idTypeAnnotation == 2)
	      $action = 'surligner';
	  ?>
	    <a class="lienGroupe" href="<?=site_url()."document/afficher/".$annotation->idDocument."/groupe/".$annotation->idGroupe?>"><?=$annotation->intitule?></a> - <strong><?=$annotation->emailUtilisateur?></strong> à <?=$action?> le document "<u><?=$annotation->titre?></u>"<br>
	  <?php
	  }
	?>
  </div>
</div>
<script type="application/javascript">
	$(document).ready(function() {
		$('#submit').click(function() {
			var form_data = {
				nom :		$('#nom').val(),
				prenom :	$('#prenom').val(),
				ajax : '1'
			};
			$.ajax({
				url: "<?=site_url('membre/ajax_info_profil'); ?>",
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
