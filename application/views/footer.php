<nav class="navbar-default navbar-fixed-bottom">
  <div class="faitPar">Université d'Évry Val d'Essonne 2013/2014</div> 
</nav>
<script src="<?=base_url()?>asset/js/jquery-1.10.2.min.js"></script> 
<script src="<?=base_url()?>asset/js/bootstrap.js"></script>

<?php if($nav == "home"): ?>
<script>
<!-- 
	(function($) {
	
		/* focus sur l'élément de recherche dans la barre de navigation */
		
	})(jQuery);
-->
</script>
<?php elseif($nav="membre"): ?>
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