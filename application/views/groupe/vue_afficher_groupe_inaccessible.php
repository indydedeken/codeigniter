<div class="jumbotron" style="text-align:center !important;">
	
<?php 
	if($check) {
?>
		<p>L'administrateur analyse votre demande.</p>
<?php	
	} else {
?>
    <p>Vous n'êtes pas sur la liste. Impossible de vous ouvrir les portes du groupe.</p><br>
    <a href="<?=base_url('acces')?>/demande/param1/<?=$groupe[0]->id?>/param2/<?=str_replace("@", "-", $groupe[0]->emailAdministrateur)?>/param3/<?=str_replace("@", "-", $this->session->userdata('email'))?>">
        <button class="btn btn-lg btn-info">Demander l'accès</button>
    </a>
<?php 
	}
?>
    
</div>