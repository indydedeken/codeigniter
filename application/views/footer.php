<nav class="navbar-default navbar-fixed-bottom">
  <div class="faitPar">Université d'Évry Val d'Essonne 2013/2014</div> 
</nav>
<script src="<?=base_url()?>asset/js/bootstrap.js"></script>
<script>
<!--
	// Soumission du formulaire de Search dans le header
	$( "#formSearch" ).submit(function( event ) {
		var element		= $("#searchHidden");
		var category	= element.data('category');
		var idElement	= element.data('id');
		var label		= element.data('label');
		
		// possibilité d'utiliser la recherche pour : GROUPE, DOCUMENT
		if (category == "groupe") {
			$(location).attr('href',"<?=base_url('groupe/afficher')?>/" + idElement);
		} else if (category == "document") {
			$(location).attr('href',"<?=base_url('document/afficher')?>/" + idElement);
		}
		
		// empeche le formulaire de se valider
		event.preventDefault();	
	});
-->
</script>
<?php if($this->uri->segment(1) == "document" && $this->uri->segment(2) == "creer"): ?>
<script>
      
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
</div>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  
    ga('create', 'UA-50566532-2', 'compri.me');
    ga('send', 'pageview');
</script>
</body></html>