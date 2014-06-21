<div class="container"> 
  <br>
  <br>
  <div class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Gestion des groupes</h1>
      <div class="groupelien">
      	<a href="<?=site_url()?>groupe/creer">
      		Créer un nouveau groupe
    	</a>
        <hr style="margin:10px 0px 10px 0; background:#666666; height:1px;opacity:0.45;">
      	<a href="<?=base_url('acces')?>">
      		Les accès aux groupes
    	</a>
      </div>
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_profil_infoPerso">
            <h2>Mes groupes</h2>
            <p>Liste des groupes disponibles :</p>
            <div id="liste-groupe" class="list-group">
            <?php 
			$variableNbDoc = "";
			
			foreach($nbDocument as $nbDoc)
			{
				$variableNbDoc[] = $nbDoc->num_rows();
			}
				
			$i = 0;
			
			foreach($groupe->result() as $item) { ?>
			   <div class="btn-group btn-group-justified">
				<a class="list-group-item" href="<?=base_url('groupe/afficher/'.$item->id)?>" title="Groupe - <?=$item->intitule?>">
					<span class="badge pull-right"><?=$variableNbDoc[$i]?></span>
					<h5 class="list-group-item-heading"><?=$item->intitule?><span style="font-weight:300; font-style:italic;"> - <?=$item->dateCreation?> - 
					<?php echo $item->nb." "; echo ($item->nb > 1) ? "membres" : "membre";?></span></h5>
					<?=$item->description?>
				</a>
			</div>
			<?php 
			$i++;
			} ?>
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
