<div class="container"> 
  <br>
  <br>
  <div id="" class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Gestion des groupes</h1>
      <br>
      <br>
      	<a href="<?=site_url()?>groupe/creer">
      		<button type="button" class="btn btn-success btn-lg" style="width:230px;border-radius:0;">Créer un nouveau groupe</button>
    	</a>
      	<a href="<?=base_url('acces')?>">
      		<button type="button" class="btn btn-lg" style="width:230px;border:1px solid #BBB;border-radius:0;">Les accès aux groupes</button>
    	</a>
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_profil_infoPerso">
            <h2>Mes groupes</h2>
            <p>Liste des groupes disponibles :</p>
            <div id="liste-groupe" class="list-group">
            <?php 
				foreach($groupe->result() as $item) { ?>
                   <div class="btn-group btn-group-justified">
                    <a class="list-group-item" href="<?=base_url('groupe/afficher/'.$item->id)?>" title="Groupe - <?=$item->intitule?>">
						<span class="badge pull-right">Nb de documents</span>
						<h5 class="list-group-item-heading"><?=$item->intitule?><span style="font-weight:300; font-style:italic;"> - <?=$item->dateCreation?> - 
						<?php echo $item->nb." "; echo ($item->nb > 1) ? "membres" : "membre";?></span></h5>
                        <?=$item->description?>
					</a>
				</div>
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
