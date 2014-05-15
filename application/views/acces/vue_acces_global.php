<div class="container">
	<div>
    	<div class="annonce">
	        <h1>Ils veulent accéder à vos groupes...</h1>
    	</div>
        <div class="blocGroupes">
        <?php 
			
			$tabGrp = array();
			
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
					?>
						<li id="<?=$superString?>">
                            <?=$utilisateur?>
                        </li>
					<?php
						}
					?>
                </ul>
            </div>	
		<?php
        	}
		?>
        </div>
    </div>
    <div>
    	<div class="annonce">
        	<h1>Les groupes auxquelles vous voulez accéder...</h1>
        </div>
        <!--<div class="blocAccesUser">-->
        	<div class="blocAccesUser">
              <div class="col-md-3-perso blocEnAttente">
                <p class="lead">En attente</p>
                <ul>
                    <?php 
                        if(!$groupes['wait']) {
                            echo 'Aucune demande n\'est en cours !';
                        } else {
                            foreach($groupes['wait'] as $item) {
                                ?>
                                <li><?=$item->intitule?></li>
                                <?php
                            }
                        }
                    ?>
                </ul>
              </div>
              <div class="col-md-3-perso blocAccepte">
                <p class="lead">Accepté</p>
                <ul>
                    <?php 
                        if(!$groupes['ok']) {
                            echo 'Aucun groupe ne vous a accepté :(';
                        } else {
                            foreach($groupes['ok'] as $item) {
                                ?>
                                <li><?=$item->intitule?></li>
                                <?php
                            }
                        }
                    ?>
                </ul>
              </div>
              <div class="col-md-3-perso blocRefuse">
                <p class="lead">Refusé</p>
                <ul>
                    <?php 
                        if(!$groupes['ko']) {
                            echo 'Aucun groupe ne vous a refuséaccepté :(';
                        } else {
                            foreach($groupes['ko'] as $item) {
                                ?>
                                <li><?=$item->intitule?></li>
                                <?php
                            }
                        }
                    ?>
                </ul>
              </div>
			<!--</div>-->
        </div>
    </div>
</div>