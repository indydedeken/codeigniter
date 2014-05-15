<div class="jumbotron">
	<a href="<?=base_url('acces')?>/demande/param1/<?=$groupe[0]->id?>/param2/<?=str_replace("@", "-", $groupe[0]->emailAdministrateur)?>/param3/<?=str_replace("@", "-", $this->session->userdata('email'))?>">
	    <button class="btn btn-info">Demander l'accès</button>
	</a>
    <p>Vous n'êtes pas sur la liste. Impossible de vous ouvrir les portes du groupe.</p>
</div>