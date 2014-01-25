<div class="container"> 
  <br>
  <br>
  
  <div id="finDePage" class="row annonce">
    <div class="col col-sm-3 col-md-2">
      <h1>Profil</h1>
    </div>
    <div class="justify col-sm-8 col-md-9">
      	<div class="bloc_profil_infoPerso">
            <h2>Mes informations</h2>
            <?=form_open('membre/profil')?>
            <div class="libelle">Nom</div>
            <div class="valeur"><?=form_input(array('id'=>'nom', 'name'=>'nom','value'=>$this->session->userdata('nom'),'class'=>'form-control','style'=>''))?></div>
            <div class="libelle">Prénom</div>
            <div class="valeur"><?=form_input(array('id'=>'prenom', 'name'=>'prenom','value'=>$this->session->userdata('prenom'),'class'=>'form-control','style'=>''))?></div>
			<br>
            <div><?=form_submit('submit','Editer','id="submit" class="btn btn-default btn-lg" style="width:300px"')?></div>
			<?=form_close()?>
        </div>   
             
        
        
        <!-- affichage des documents de l'utilisateur -->
        <h2>Mes documents</h2>
        <a class="lienGroupe" href="">Evry Search</a> - <strong>@Judith</strong> à rayé 8 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br>
      <a class="lienGroupe" href="">Evry Search</a> - <strong>@Axel</strong> à surligné 2 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br>
      <a class="lienGroupe" href="">Evry Search</a> - <strong>@Judith</strong> à rayé 8 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br>
      <a class="lienGroupe" href="">Fontainebleau Search</a> - <strong>@Axel</strong> à surligné 2 lignes du document "<u>Vers un modèle computationnel unifié...</u>"<br>
      <br>
      	
        <!-- affichage des groupes de l'utilisateur -->
        <h2>Mes groupes</h2>
      	<a class="lienGroupe" href="">Evry Search</a> - <strong>@Judith</strong> à rayé 8 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br>
      <a class="lienGroupe" href="">Evry Search</a> - <strong>@Axel</strong> à surligné 2 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br>
      <a class="lienGroupe" href="">Evry Search</a> - <strong>@Judith</strong> à rayé 8 lignes du document "<u>Vers un modèle computationnel unifié des émotions</u>"<br>
      <a class="lienGroupe" href="">Fontainebleau Search</a> - <strong>@Axel</strong> à surligné 2 lignes du document "<u>Vers un modèle computationnel unifié...</u>"<br></div>
  </div>
</div>

<script type="application/javascript">
	$(document).ready(function() {
		$('#submit').click(function() {
			var form_data = {
				nom :		$('#nom').val(),
				prenom :	$('#prenom').val(),
				ajax : '1'
			};
			$.ajax({
				url: "<?=site_url('membre/ajax_info_profil'); ?>",
				type: 'POST',
				async : true,
				data: form_data,
				success: function(msg) {
					// /!\ laisser le mot "erreur" dans msg pour afficher la bonne notification 
					if (/rreur/.test(msg)) {
					  generateError(msg);	 
					} else {
					  generateSuccess(msg);	
					}
				},
				error: function() {
					generateError('Une erreur s\'est produite.<br>Impossible de terminer la requête.');
				}
			});
			return false;
		});
	});
</script>
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
