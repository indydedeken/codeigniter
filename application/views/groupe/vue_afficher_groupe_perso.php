<div class="container"> 
<a href="#modalPageSlide" class="callModalWindow">&nbsp;&nbsp;+</a>
  <br>
  <br>
  <div class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1 style="font-size:20px;">Bibliothèque personnelle</h1>
      <!-- affichage des informations du groupe -->
            <div style="text-align:center;">
            <?php 
				foreach($groupe->result() as $item) { 
                	echo $item->description;
				} 
			?>
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
    <button type="button" class="btn btn-xs right" onClick="javascript:$.pageslide.close()">Fermer</button>
</div>
<script src="<?=base_url()?>asset/js/jquery.pageslide.min.js"></script>
<script type="application/javascript"><!--
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
		
		$('<?php echo $elts;?>').click(function(e) {
			var obj = e.currentTarget.attributes.id.value.split('_');
			window.location.replace("<?php echo base_url('document/afficher/');?>/"+obj[1]+"/groupe/"+<?=$idGroupe?>);
		});
		<!-- ./Redirection		
		
		<!-- JS - PageSlide
		$(".callModalWindow").pageslide({ direction: "left", modal: true });
		//lancer le pageSlide dès le début 
		//$('.callModalWindow').trigger('click');
		<!-- ./PageSlide
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
