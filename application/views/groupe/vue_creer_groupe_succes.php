<div class="container"> <br>
  <br>
  <div id="" class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Création de groupe :</h1>
    </div>
    <div class="justify col-sm-8 col-md-9">
      <div class="">
		Le groupe "<?=$nom?>" est créé.<br>
		Sa description est : "<?=$description?>".<br>
		Vous allez être redirigé vers la page du groupe dans un instant.
      </div>
    </div>
  </div>
</div>
<script>
$(function() {
	var direction = 'window.location.replace("<?php echo base_url('groupe/afficher').'/'.$idGroupe;?>");';
	setTimeout(direction, 4000); 
});
</script> 
<script type="application/javascript"><!--
	$(document).ready(function() {
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