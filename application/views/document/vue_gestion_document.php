<div class="container"> 
  <br>
  <br>
  <div id="" class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Gestion des documents</h1>
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_profil_infoPerso">
            <h2>Mes documents</h2>
			<p>Liste des documents disponibles :</p>
            <div id="liste-document" class="list-group">
            <?php 
				foreach($documents->result() as $item) { ?>
                    <a class="list-group-item" href="<?=base_url('document/afficher/'.$item->id)?>" title="document">
						<?=$item->titre?> - <?=$item->auteur?><span class="badge pull-right"><?=$item->libelle?></span>
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
