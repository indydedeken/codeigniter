<div class="container"> 
<a href="#modalPageSlide" class="callModalWindow">&nbsp;&nbsp;+</a>
  <br>
  <br>
  <div id="" class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Mon groupe</h1>
      <!-- affichage des informations du groupe -->
            <div style="text-align:center;">
            <?php 
				foreach($groupe->result() as $item) { ?>
                	<h5><?=$item->intitule?></h5>
					Depuis le <?=$item->dateCreation?><br>
					<br><?=$item->description?><br><br>
					<div id="actions" class="btn-group" style="width:100%">
						<button id="quitGroupe" class="btn btn-default btn-primary" type="button">Quitter</button>
						<?php if($estAdministrateur): ?>
							<button id="editGroupe" class="btn btn-default btn-primary" type="button">Éditer</button>
							<button id="delGroupe" class="btn btn-default btn-danger" type="button">Supprimer</button>
						<?php endif;?>
			        </div>
			<?php } ?>
			</div>

			<!-- Button trigger modal : BOUTON POUR INVITER MEMBRE DANS LE GROUPE-->
			<button id="popupAddMember" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display:none"></button>

			<!-- Modal : POPUP POUR INVITER MEMBRE DANS LE GROUPE-->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times; </button>
						<?php foreach($groupe->result() as $item) ?>
						<p>
						<h5 class="modal-title" id="popupTitre1">Inviter un membre dans le groupe <h4 id="popupTitre2"><?=$item->intitule ?></h4></h5> 
						</p>
						</div>
					<div class="modal-body">
						<form id="formSearchMember" class="navbar-form navbar-right" role="search">
							<input id="searchMember" type="search" class="form-control" placeholder="chercher un membre..." spellcheck="false" value="" autocomplete="off">
							<input id="searchHiddenMember" type="hidden">
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
						<button id='invitMembre' type="button" class="btn btn-primary">Inviter Membre</button>
					</div>
					</div>
				</div>
			</div>	
    </div>
    <div id="contenuGroupe" class="justify col-sm-8 col-md-9">
    	<div style="margin-top:10px;margin-bottom:10px;text-align:left;">
	    	<button id="triTitre" class="btn btn-xs" style="padding:0 10px;margin:0 20px;">Titre A-Z</button>
            <button id="triAuteur" class="btn btn-xs" style="padding:0 10px;margin:0 20px;">Auteur A-Z</button>
            <button id="triDate" class="btn btn-xs" style="padding:0 10px;margin:0 20px;">Date A-Z</button>
            <button id="triEtat" class="btn btn-xs" style="padding:0 10px;margin:0 20px;">Etat A-Z</button>
        </div>
        <div class="bloc_profil_infoPerso">
        	<table id="table" class="table table-hover listeDocument">
				<thead>
					<tr>
						<th>Titre</th>
						<th>Auteur</th>
						<th>Date</th>
						<th>Etat</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($documents->result() as $item) { ?>
                    <tr id="document_<?php echo $item->idDocument; ?>" <?php if($item->etat == 2) echo 'class="danger"'; ?>>
                        <td><?=$item->titre?></td>
                        <td><?=$item->auteur?></td>
                        <td><?=$item->dateCreation?></td>
                        <td><?=$item->libelle?></td>
                    </tr>
                <?php } ?>
				</tbody>
			</table>
        </div>   
        
	</div>
</div>
<div id="modalPageSlide">
    <a href="javascript:$.pageslide.close()" style="float:right">
    	<button type="button" class="btn btn-xs">Fermer</button>
   	</a>
    <h4>Collaborateurs</h4> 
    
    <!-- affichage des membres du groupe -->
    <?php
		$attributes = array('class' => 'test', 'id' => 'myform');
		echo form_open('groupe/ajax_supprimer_membre');
	?>
    <ul id="listeMembre">
        <?php
			$i=0;
            foreach($membresGroupe->result() as $item) { 
			?>
			<li>
				<?php if($estAdministrateur): ?>
					<?php if($item->emailUtilisateur == $this->session->userdata('email')): ?>
						<p><?=$item->prenom." ".$item->nom." ".$item->emailUtilisateur.""?></p>
					<?php else :
					?>
						<input id="<?=$i?>" type="checkbox" name="option[]" value="<?=$item->emailUtilisateur?>">
						<label for="<?=$i?>"><?=$item->prenom." ".$item->nom." ".$item->emailUtilisateur?></label>
					<?php endif;?>	
				<?php else : ?>
						<?=ucfirst($item->prenom)?> <?=ucfirst($item->nom)?> <?=$item->emailUtilisateur?>
				<?php endif; ?>
				
			</li>
                
        <?php 
			$i++;
			}	
		?>			
    </ul>
    <?php 
		echo form_close();
	?>
	<?php if($estAdministrateur): ?>
			<button id="delMember" class="btn btn-default btn-danger" type="button">Supprimer</button>	
	<?php endif;?>
			<button id="addMember" class="btn btn-primary btn-primary" type="button">Inviter</button>
</div>
<script src="<?=base_url()?>asset/js/jquery.pageslide.min.js"></script>
<script type="application/javascript"><!--
	$('#addMember').click(function() {
			$('#popupAddMember').trigger('click');
		});

	$(document).ready(function() {
		
		$('#triTitre').click(function() {
			$("[aria-label~='Titre:']").trigger('click');
		});
		$('#triAuteur').click(function() {
			$("[aria-label~='Auteur:']").trigger('click');
		});
		$('#triDate').click(function() {
			$("[aria-label~='Date:']").trigger('click');
		});
		$('#triEtat').click(function() {
			$("[aria-label~='Etat:']").trigger('click');
		});
			
		var table = $('#table').DataTable({
			"bPaginate": false,
			"bLengthChange": false,
			"bFilter": true,
			"bSort": true,
			"bInfo": false,
			"bAutoWidth": false
		});
			
		<!-- CSS - Resizer les boutons d'action de la page
		var nbBtn = $('#actions button').length;
		var tailleBtn = 100/nbBtn;
		$('#actions button').css('width', tailleBtn+'%');
		<!-- ./CSS
		
		<!-- JS - Redirection vers le document sur lequel l'utilisateur clic
		<?php 
		$elts = ''; 
		foreach($documents->result() as $item) { 
			$elts .= "#document_".$item->idDocument.", "; 
		} 
		$elts =  substr($elts, 0, -2);
		?>
		
		$('<?=$elts?>').click(function(e) {
			var obj = e.currentTarget.attributes.id.value.split('_');
			window.location.replace("<?php echo base_url('document/afficher/');?>/"+obj[1]+"/groupe/"+<?=$idGroupe?>);
		});
		<!-- ./Redirection		
		
		<!-- JS - PageSlide
		$(".callModalWindow").pageslide({ direction: "left", modal: true });
		//lancer le pageSlide dès le début 
		//$('.callModalWindow').trigger('click');
		<!-- ./PageSlide
		
		<!-- AJAX - Quitter le groupe
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
		<!-- ./AJAX		
		
		<!-- AJAX - supprimer membre du groupe
		$('#delMember').click(function() {
		
			var selected = new Array();
			selected.push('<?=$this->session->userdata("email")?>');
			selected.push('<?=$idGroupe?>');

			$('input[name="option[]"]:checked').each(function() {
				selected.push(this.value);
			});
			
			$.ajax({
				url: "<?=site_url('groupe/ajax_supprimer_membre'); ?>",
				type: 'POST',
				async : true,
				data: { list:selected },
				success: function(msg) {
					// /!\ laisser le mot "erreur" dans msg pour afficher la bonne notification 
					if (/rreur/.test(msg)) {
						generateError(msg);	 
					} else {
						generateSuccess(msg);
						var direction = 'window.location.replace("<?php echo base_url('groupe/afficher');?>/' + selected[1] + '");';
						setTimeout(direction, 2000); 
					}
				},
				error: function() {
					generateError('Veuillez sélectionner au moins un utilisateur !');
				}
			});
			return false;
		});
		<!-- ./AJAX suppression de membre au groupe
		
		<!-- AJAX - Editer le groupe
		$('#editGroupe').click(function() {
			var form_data = {
				email : '<?=$this->session->userdata("email")?>',
				groupe : '<?=$idGroupe?>',
				ajax : 	'1'
			};
			$.ajax({
				url: "<?=site_url('groupe/ajax_ecran_edition_groupe'); ?>",
				type		: 'POST', 
				async 		: true, 
				data		: form_data, 
				dataType	: 'html', 
				success		: function(data) { 
					$('#contenuGroupe').html(data);
				},
				error: function() {
					generateError('Une erreur s\'est produite.<br>Impossible de terminer la requête.');
				}
			});
			return false;
		});
		<!-- ./AJAX	
		
		<!-- AJAX - Inviter un membre
		$('#invitMembre').click(function() {
			var getMembre = document.getElementById("searchMember").value; 
			var form_data = {
				email : '<?=$this->session->userdata("email")?>',
				groupe : '<?=$idGroupe?>',
				membre : getMembre,
				ajax : 	'1'
			};
			console.log(form_data.membre);

			$.ajax({
				url: "<?=site_url('groupe/ajax_inviter_membre'); ?>",
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
							var direction = 'window.location.replace("<?php echo base_url('groupe/afficher');?>/' + form_data.groupe + '");';
							setTimeout(direction, 2000); 
						}).trigger('click'); // simuler click pour décrémenter la variable
					}
				},
				error: function() {
					generateError('Une erreur s\'est produite.<br>Impossible de terminer la requête.');
				}
			});
			return false;
		});
		<!-- ./AJAX	
		
	});
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
			type        : 'warning',
			dismissQueue: true,
			layout      : 'topCenter',
			theme       : 'defaultTheme',
			closeWith	: ['click'],
			maxVisible	: 3,
			timeout		: false
		});
	}
</script>
<script>	
$(function() {
	// données qui alimentent le search du popup inviter membre
    var dataM = [
	// liste des membres
	<?php
	foreach($_SESSION['listeMembres'] as $item) {
	?>
	
	{ id: "<?=$item->email?>", label: "<?=$item->email?>", category: "membre"},
	<?php	
	}
	?>
    ];
    $("#searchMember").autocomplete({
		delay: 0,
		minLength: 5,
		source: dataM,
		select: function( event, ui ) {
			// traitement de la recherche selectionnée
			//$("#searchMember").value = ui.item.label;
			$("#searchMember").attr("value", ui.item.label);
			$("#searchHiddenMember")
				.attr("data-id", ui.item.id)
				.attr("data-label", ui.item.label)
				.attr("data-category", ui.item.category)
				.attr("value", ui.item.label);
			return false;
		}
    });
});	
	
//$( "#SearchMember" ).autocomplete( "option", "appendTo", "#formSearchMember" );	
</script>
