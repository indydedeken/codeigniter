<div class="container"> 
  <br>
  <br>
  <div class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Document</h1>
		<?php foreach($documents->result() as $item) { ?>
                	<img src="<?=str_replace('-html.html','.png',base_url().$item->contenuOriginal)?>" height="150" width="200"> </img>
			<?php } ?>
		<?php 
			if($idGroupe == 0) {
				foreach($listeDocumentsPerso->result() as $item) {?>
                	<img src="<?=str_replace('-html.html','.png',base_url().$item->contenuOriginal)?>" height="150" width="200"> </img>
		<?php 	} 
			}
			else {
				foreach($listeDocumentsGroupe->result() as $item) {	?>
					<img src="<?=str_replace('-html.html','.png',base_url().$item->contenuOriginal)?>" height="150" width="200"> </img>
		<?php	}
			}	?>		
			
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_groupe">
      		<!-- affichage des informations du document -->
			<?php foreach($documents->result() as $item) { ?>
                	<iframe src="<?=base_url().$item->contenuOriginal?>" height="900" width="137%"> </iframe>
					
			<?php } ?>
			
            <dl class="dl-horizontal">
			</dl>
        </div>
        <div>
        	<!-- affichage des membres du groupe -->
        	<dl class="dl-horizontal">
            </div>
	</div>
</div>
<script type="application/javascript">
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
