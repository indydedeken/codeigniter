<nav class="navbar-default navbar-fixed-bottom">
  <div class="faitPar">Université d'Évry Val d'Essonne 2013/2014</div> 
</nav>
<script src="<?=base_url()?>asset/js/bootstrap.js"></script>
<script>
	// Soumission du formulaire de Search dans le header
	$( "#formSearch" ).submit(function( event ) {
		var element = $("#searchHidden");
		alert("J'en fais quoi des données ??? \n" + element.data('id') + "_" + element.data('label') + "_"  + element.data('category'));
		event.preventDefault();
	});
</script>
<?php if($this->uri->segment(1) == "home"): ?>
<script>
<!-- 
	(function($) {
	
		
		
	})(jQuery);
-->
</script>
<?php elseif($this->uri->segment(1) == "membre" || $this->uri->segment(1) == "creer") : ?>
<script>
<!-- 
	(function($) {
		
		// focus sur le premier input du formulaire connexion & inscription
		$(document).on('click', 'li', function(){
			$('div.active input').first().focus();
		});
		
	})(jQuery);
-->
</script>
<?php endif; ?>
</body></html>