<div class="container">
<br>
<br>
<div id="" class="annonce">
<div class="col col-sm-4 col-md-3">
	<h1>Gestion des documents</h1>
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		Sélection d'un groupe
		<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" style="text-align:left;">
			<?php
			foreach($groupes->result() as $item) { 
			?>
				<li><a href="#groupe<?=$item->idGroupe?>">Groupe <?=$item->intitule?></a></li>
			<?php
			}
			?>
			<li><a href="#groupe0">Bibliothèque personnelle</a></li>
		</ul>
	</div>
</div>
<div class="justify col-sm-8 col-md-9">
	<div class="bloc_profil_infoPerso">
		<h2>Mes documents</h2>
		<div id="liste-document" class="list-group">
			<div role="toolbar" class="btn-toolbar">
				<?php 
				$idGroupeTmp = 0;
				foreach($documents->result() as $item) { 
					if($item->idGroupe != $idGroupeTmp){
						$idGroupeTmp = $item->idGroupe;
					?>
						<h2 id="groupe<?=$item->idGroupe?>"><small><?=$item->intitule?></small></h2>	
					<?php
					}
					?>	
					<a id="document_<?=$item->id?>" class="list-group-item" href="<?=base_url('document/afficher/'.$item->id.'/groupe/'.$item->idGroupe)?>" title="document">
						<?=$item->titre?><br>
						par <?=$item->auteur?><span class="badge pull-right"><?=$item->libelle?></span>
					</a>			   
				<?php } ?>
				<h2 id="groupe0"><small>Bibliothèque personnelle</small></h2>	
				<?php 
				$idGroupeTmp = 0;
				foreach($documentsPersonnels->result() as $item) { 
					if($item->idGroupe != $idGroupeTmp){
						$idGroupeTmp = $item->idGroupe;
					?>
						
					<?php
					}
					?>	
					<a id="document_<?=$item->id?>" class="list-group-item" href="<?=base_url('document/afficher/'.$item->id.'/groupe/'.$item->idGroupe)?>" title="document">
						<strong><?=$item->titre?></strong><br>
						par <?=$item->auteur?><span class="badge pull-right"><?=$item->libelle?></span>
					</a>			   
				<?php } ?>
				
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
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
