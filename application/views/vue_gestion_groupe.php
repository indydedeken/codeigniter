<div class="container"> 
  <br>
  <br>
  <div id="finDePage" class="row annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Gestion des groupes</h1>
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_profil_infoPerso">
            <h2>Mes groupes</h2>
			<p>Liste des groupes disponibles :</p>
            <div id="liste-groupe" class="list-group">
            <?php 
				foreach($groupe->result() as $item) { ?>
                    <a class="list-group-item" href="<?=base_url('groupe/afficher/'.$item->id)?>" title="groupe">
						<?=$item->intitule?> - <?=$item->dateCreation?><span class="badge pull-right">NB personne</span><br>
                        <?=$item->description?>
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
