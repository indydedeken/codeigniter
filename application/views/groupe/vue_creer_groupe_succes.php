<div class="container">
	<br>
	<br>
	<div class="annonce">
        <div style="background:#8AB7A0;padding-top:20px;font-weight:400;font-size:26px;text-align:center;" class="">
        	<p style="color:#FFFFFF">
                Le groupe "Test" a été créé !
            </p>
            <img alt="Patience..." src="http://markus.compri.me/asset/img/wait.gif" id="image">
        </div>
    </div>
</div>
<script>
	$(function() {
		
		$(window).resize(function() {
			$('#image').css('width', $(window).width()-200);
		});

		var direction = 'window.location.replace("<?php echo base_url('groupe/afficher').'/'.$idGroupe;?>");';
		setTimeout(direction, 3000); 
	});
</script>