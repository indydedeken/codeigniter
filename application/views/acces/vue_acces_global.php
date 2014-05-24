<div class="container">
	<div>
    	<div class="annonce">
	        <h1>Ils veulent accéder à vos groupes...</h1>
    	</div>
        <div class="blocGroupes">
        <?php 
			
			$tabGrp = array();
			//var_dump($groupesPerso);
			
			// rangement des données
			foreach($groupesPerso as $item) {
				$tabGrp[$item->idGroupe]['idGroupe'][] 			= $item->idGroupe;
				$tabGrp[$item->idGroupe]['intitule'][] 			= $item->intitule;
				$tabGrp[$item->idGroupe]['intitule'][] 			= $item->intitule;
				$tabGrp[$item->idGroupe]['emailUtilisateur'][]	= $item->emailUtilisateur;
			}
			
			// compteur de groupe
			$nbGroupe = count($tabGrp);
			
			// boucle sur les groupes
			foreach($tabGrp as $groupe) {
				
				// organisation du design en fonction du nb de groupe
				if ($nbGroupe == 1) 
					$taille = 1;
				else if( ($nbGroupe % 2) == 0 )
					$taille = 2;
				else if ( ($nbGroupe % 3) == 0 )
					$taille = 3;
					
		?>
			<div class="col-md-<?=$taille?>-perso" >
                <h6><?=$groupe['intitule'][0]?></h6>
                <ul>
                    <?php 
						// boucle sur les demandes d'utilisateur
						foreach($groupe['emailUtilisateur'] as $utilisateur) { 
							$superString = md5($utilisateur . $groupe['intitule'][0]);
							
							$urlValidation = base_url('acces') . "/validation";
							$urlValidation .= "/param1/" . $groupe['idGroupe'][0];
							$urlValidation .= "/param2/" . str_replace('@', '-', $this->session->userdata('email'));
							$urlValidation .= "/param3/" . str_replace('@', '-', $utilisateur);
							$urlValidation .= "/param4/1";
					?>
						<li id="<?=$superString?>">
                            <a href="<?=$urlValidation?>"><?=$utilisateur?></a>
                        </li>
					<?php
						}
					?>
                </ul>
            </div>	
		<?php
        	}
		?>
        
        
        <?php 
			if(empty($tabGrp)) {
		?>
        	<p style="padding:20px;">
            	Personne ne demande l'accès à vos groupes.
            	<br><br>
            	<!--<a href="#" class="btn btn-primary btn-lg" role="button">Invitez des amis</a>-->
				<!--<button id="popupAddMember" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display:none"></button>-->
				<button id="addMemberOnAcces" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1" type="button">Inviter des amis</button>

            </p>
        <?php
			}
		?>
        </div>
		
		<!-- Modal : POPUP POUR INVITER MEMBRE DANS LE GROUPE-->
				
			<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times; </button>
						
						<h5 class="modal-title" id="popupTitre1">Invitation au groupe </h5> 
						
                        </div>
					<div class="modal-body">
						<form id="formSearchMemberOnAcces" class="navbar-form navbar-right" role="search">
							<p>
								Groupe &nbsp;:
								<SELECT id="selectionGroupeOnAcces" name="selectionGroupeOnAcces" size="1" class="btn btn-default dropdown-toggle" >
								<option value="0" selected disabled> Sélectionner un groupe </option>
								<?php foreach($groupesUtilisateur->result() as $item) { ?>
									<OPTION value="<?=$item->id?>"> <?=$item->intitule?> </OPTION>	
								<?php } ?>
								</SELECT>
							</p>
							<p>
								Membre :
								<input id="searchMemberOnAcces" type="search" class="form-control" placeholder="chercher un membre..." spellcheck="false" value="" autocomplete="off">
								<input id="searchHiddenMemberOnAcces" type="hidden">
							</p>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
						<button id='invitMembreOnAcces' type="button" class="btn btn-primary">Inviter Membre</button>
					</div>
					</div>
				</div>
			</div>
		
		
    </div>
    <div>
    	<div class="annonce">
        	<h1>Les groupes auxquels vous voulez accéder...</h1>
        </div>
        <!--<div class="blocAccesUser">-->
        	<div class="blocAccesUser">
              <div class="col-md-3-perso blocEnAttente">
                <p class="lead">En attente</p>
                    <?php 
                        if(!$groupes['wait']) {
                            echo 'Aucune demande n\'est en cours !';
                        } else {
					?>
                        <ul>
                	<?php
                            foreach($groupes['wait'] as $item) {
                                ?>
                                <li><?=$item->intitule?></li>
                                <?php
                            }
					?>
                        </ul>
                	<?php
                        }
                    ?>
              </div>
              <div class="col-md-3-perso blocAccepte">
                <p class="lead">Accepté</p>            
                <?php 
                    if(!$groupes['ok']) {
                        echo 'Aucun groupe ne vous a accepté :(';
                    } else {
                ?>
                        <ul>
                <?php
                        foreach($groupes['ok'] as $item) {
                            ?>
                            <li><?=$item->intitule?></li>
                            <?php
                        }
                ?>
                        </ul>
                <?php
                    }
                ?>
              </div>
              <div class="col-md-3-perso blocRefuse">
                <p class="lead">Refusé</p>
                
                    <?php 
                        if(!$groupes['ko']) {
                            echo 'Aucun groupe ne vous a refusé :(';
                        } else {
					?>
                        <ul>
                	<?php
                            foreach($groupes['ko'] as $item) {
                                ?>
                                <li><?=$item->intitule?></li>
                                <?php
                            }
					?>
                        </ul>
               		<?php
                        }
                    ?>
              </div>
			<!--</div>-->
        </div>
    </div>


<script type="application/javascript"><!--
		<!-- AJAX - Inviter un membre
		$('#invitMembreOnAcces').click(function() {
			var getMembre = document.getElementById("searchMemberOnAcces").value; 
			var select = $("#selectionGroupeOnAcces")[0];
			var valeur = select.options[select.selectedIndex].value;

			var form_data = {
				email : '<?=$this->session->userdata("email")?>',
				groupe : valeur,
				membre : getMembre,
				ajax : 	'1'
			};
			//console.log(form_data.membre);
			//console.log(form_data.groupe);
			console.log(valeur);

			$.ajax({
				url: "<?=site_url('groupe/ajax_inviter_membre'); ?>",
				type: 'POST',
				async : true,
				data: form_data,
				success: function(msg) {
					// /!\ laisser le mot "erreur" dans msg pour afficher la bonne notification 
					if (/rreur/.test(msg)) {
					  generateError(msg);	 
					} else {
						generateSuccess(msg);	
						$(document).one('click', function(){ 
							// décrémenter la bulle
							$('#groupe-badge').html($('#groupe-badge').text()-1);
							// modifier l'id du bouton pour stopper l'action de quitter
							$('#groupe-badge').attr("id", "groupe-badge-ok");
							$("button, input").attr("disabled", true);
							//var direction = 'window.location.replace("<?php echo base_url('groupe/afficher');?>/' + form_data.groupe + '");';
							var direction = 'window.location.replace("<?php echo base_url('acces');?>);';
							setTimeout(direction, 2000); 
						}).trigger('click'); // simuler click pour décrémenter la variable
					}
				},
				error: function() {
					generateError('Une erreur s\'est produite.<br>Impossible de terminer la requête.');
				}
			});
			return false;
		});
		<!-- ./AJAX	
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

<script>	
$(function() {
	// données qui alimentent le search du popup inviter membre
    var dataM = [
	// liste des membres
	<?php
	foreach($_SESSION['listeMembres'] as $item) {
	?>
	
	{ id: "<?=$item->email?>", label: "<?=$item->email?>", category: "membre"},
	<?php	
	}
	?>
    ];
    $("#searchMemberOnAcces").autocomplete({
		delay: 0,
		minLength: 5,
		source: dataM,
		select: function( event, ui ) {
			// traitement de la recherche selectionnée
			//$("#searchMember").value = ui.item.label;
			$("#searchMemberOnAcces").attr("value", ui.item.label);
			$("#searchHiddenMemberOnAcces")
				.attr("data-id", ui.item.id)
				.attr("data-label", ui.item.label)
				.attr("data-category", ui.item.category)
				.attr("value", ui.item.label);
			return false;
		}
    });
});	
	
//$( "#SearchMember" ).autocomplete( "option", "appendTo", "#formSearchMember" );	
</script>