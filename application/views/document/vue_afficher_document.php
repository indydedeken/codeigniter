<div class="container"> 
  <br>
  <br>
  <div id="" class="annonce">
    <div class="col col-sm-4 col-md-3">
      <h1>Mon document</h1>
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_groupe">
      		<!-- affichage des informations du document -->
            info document <?=$idDocument?>
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
