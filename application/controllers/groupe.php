<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Groupe extends CI_Controller {

	public function index() {
		// vérifier que l'utilisateur est connecté
		if(	$this->session->userdata('logged') && $this->session->userdata('email')) 
		{
			redirect(site_url().'groupe/gestion');
		} 
		else 
		{
			redirect('membre/register');
		}
	}

	/************************************************/
	/* groupe/gestion								*/
	/*												*/
	/* BUT : gestion des groupe d'un utilisateur	*/
	/************************************************/
	public function gestion() {
		$data['nav'] = "gestionGrp"; 
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$data['groupe']	= $this->model_groupe->getAllGroupes($this->session->userdata('email'));
			
			$this->load->view('header', $data);
			$this->load->view('groupe/vue_gestion_groupe', $data);
			$this->load->view('footer', $data);
			
		} else {
			// si non loggé && sans email
			redirect(site_url().'home');	
		
		}
	}
	
	/****************************************/
	/* groupe/afficher/<idGroupe>			*/
	/*										*/
	/* BUT : afficher les données du		*/
	/* groupe 								*/
	/****************************************/
	public function afficher() {
 		
 		$data['nav'] = "afficher"; 
 		
 		// vérifier que l'utilisateur à le droit d'accès à ce document
 		if($this->session->userdata('email') && $this->session->userdata('logged')) {
 			
 			$idGroupe = $this->uri->segment(3);
 
 			if( $idGroupe == 0 )
 			{
 				$data = '';
 				$data['groupe'] 			= $this->model_groupe->getGroupe($idGroupe);
 				$data['idGroupe']			= $idGroupe;
 				$data['documents']			= $this->model_document->getAllDocumentsPerso($idGroupe, $this->session->userdata('email'));
 				
 				$this->load->view('header', $data);
 				$this->load->view('groupe/vue_afficher_groupe_perso', $data);
 				$this->load->view('footer', $data);
 				
 			} else if( $this->model_groupe->getGroupe( $idGroupe ) ) {
 				
 				$data['groupe'] 			= $this->model_groupe->getGroupe($idGroupe);
 				$data['membresGroupe'] 		= $this->model_groupe->getAllMembresGroupe($idGroupe);
 				$data['estAdministrateur'] 	= $this->model_groupe->estAdministrateur($idGroupe, $this->session->userdata('email'));
 				$data['idGroupe']			= $idGroupe;
 				$data['documents']			= $this->model_document->getAllDocumentsGroupe($idGroupe, $this->session->userdata('email'));
 				
 				$this->load->view('header', $data);
 				$this->load->view('groupe/vue_afficher_groupe', $data);
 				$this->load->view('footer', $data);
 			
 			} else {
 				// affichage d'une page d'erreur
 				
				$data['groupe'] = $this->model_groupe->getGroupeVisiteur($idGroupe)->result();
				
 				$this->load->view('header', $data);
				$this->load->view('groupe/vue_afficher_groupe_inaccessible', $data);
 				$this->load->view('footer', $data);
 			}	
 
 		} else {
 			redirect(site_url().'membre');	
 		}
 	}
	
	/****************************************/
	/* groupe/creer/						*/
	/*										*/
	/* BUT : création de groupe				*/
	/* 		 								*/
	/****************************************/
	public function creer() {
		
		//$data['nav'] = "creer"; 
		
		// vérifier que l'utilisateur à le droit d'accès à ce document
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$data['documents'] = $this->model_document->getBibliotheque($this->session->userdata('email'));
			
			$this->load->view('header', $data);
			$this->load->view('groupe/vue_creer_groupe', $data);
			$this->load->view('footer', $data);
			
		} else {
			redirect(site_url().'membre');
		}
	}
	
	/****************************************/
	/* groupe/creation/						*/
	/*										*/
	/* BUT : création de groupe				*/
	/* 		 								*/
	/****************************************/
	public function creation() {
		
		// vérifier que l'utilisateur à le droit d'accès à ce document
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			if( $this->input->post('nom') != '' ) {
				
				// préparation des variables pour la creation du groupe
				$donnees['nom'] = $this->input->post('nom');
				$donnees['description'] = $this->input->post('description');
				$datestring = "%d/%m/%Y";
				$donnees['dateCreation'] = mdate($datestring, time());
				$donnees['emailAdministrateur'] = $this->session->userdata('email');
				
				$donneesGroupe = array(	'intitule' 		=> $donnees['nom'],
							'description'		=> $donnees['description'],
							'dateCreation'		=> $donnees['dateCreation'],
							'emailAdministrateur'	=> $donnees['emailAdministrateur']
				);
				
				// insertion du groupe en DB
				$idGroupe = $this->model_groupe->addGroupe('Groupe', $donneesGroupe);
				
				if( $idGroupe > 0 ) {
					// ajouter les documents	
					$data['idGroupe'] 	= $idGroupe;
					$data['creation'] 	= 1;
					$data['nom'] 		= $this->input->post('nom');
					$data['description'] 	= $this->input->post('description');
				}
				
				// insertion de l'utilisateur au groupe
				$donneesGroupeUtilisateur = array(	'idGroupe'		=> $idGroupe,
									'emailUtilisateur'	=> $this->session->userdata('email'),
									'dateInscriptionGroupe'	=> $donnees['dateCreation']
				);
				$this->model_groupe->addGroupe('GroupeUtilisateur', $donneesGroupeUtilisateur);
				
				// si il y a des documents, alors insertion des documents au groupe
				if(isset($_POST['documents'])) {
					foreach($_POST['documents'] as $idDoc) {
						$donnees['idDocument'] = array(	'idGroupe'		=> $idGroupe,
														'idDocument' 	=> $idDoc
						);
						$this->model_groupe->addGroupe('GroupeDocument', $donnees['idDocument']);
					}
				}
				
				$this->load->view('header', $data);
				$this->load->view('groupe/vue_creer_groupe_succes', $data);
				$this->load->view('footer', $data);
				
			} else {
			
				redirect(site_url().'groupe/creer');
			
			}
			
		} else {
			redirect(site_url().'membre');
		}
	}

	/****************************************/
	/* Méthode ajax							*/
	/*										*/
	/* BUT : action + affichage du message	*/
	/* lorsque le membre quitte un groupe	*/
	/****************************************/
	public function ajax_quitte_groupe() {

		$data['email']	= $this->input->post('email');
		$data['groupe']	= $this->input->post('groupe');

		if($this->input->post('ajax') == '1' && $data['email'] == $this->session->userdata('email') && $data['groupe']) {

			// vérifier que l'utilisateur à le droit de quitter le groupe...
			// regles de gestion............................................
			if($this->model_groupe->estAdministrateur($data['groupe'], $data['email'])) {
			
				echo 'Erreur : Un administrateur ne peut pas encore quitter un groupe.<br>Patience, cela va arriver...';	
			
			} else {
			
				if($this->model_groupe->quitterGroupe($data['groupe'], $data['email'])) {
				
					$this->session->set_userdata('nbGroupesUtilisateur', $this->model_groupe->countGroupes($data['email']));
					echo 'Succès : Vous avez bien quitté le groupe.<br>Vous allez être redirigé.';
				
				} else {
					echo 'Erreur : Vous ne pouvez pas quitter le groupe.';			
				}
			}
		} else {
			echo 'Erreur : Vous ne disposez pas des droits suffisants pour quitter le groupe.';
		}

	}
	
	/********************************************/
	/* Méthode ajax								*/
	/*											*/
	/* BUT : action + affichage du message		*/
	/* lorsqu'on supprime un membre du groupe	*/
	/********************************************/
	public function ajax_supprimer_membre() {

		$tab = $this->input->post('list');
		$data['groupe']	= $tab[0];
		$data['email']	= $tab[1];
		
		$emails = array();
		/* on commence à $i=2 car
		 * $i=0 : email admin
		 * $i=1 : id du groupe
		 */ 
		for($i=2; $i<count($tab); $i++)
		{
			array_push($emails, $tab[$i]);
		}
	
		if($this->model_groupe->supprimerMembre($data['groupe'], $emails)) {
			$this->session->set_userdata('nbGroupesUtilisateur', $this->model_groupe->countGroupes($data['email']));
			echo 'Succès ! Souhaitons bonne chance aux ex-membres du groupe.';
		} else {
			echo 'Erreur : Vous ne pouvez supprimer ces utilisateurs.';			
		}
	}
	
	/************************************************/
	/* Méthode ajax									*/
	/*												*/
	/* BUT : action + affichage du message			*/
	/* lorsqu'on invite un membre ddans le groupe	*/
	/************************************************/
	public function ajax_inviter_membre() {

		$data['email']	= $this->input->post('email');
		$data['groupe']	= $this->input->post('groupe');
		$data['membre']	= $this->input->post('membre');
		
		// on met touts les membre du groupe dans le tableau $membregroup
		// pour vérifier si le membre choisis fait deja partie du groupe
		$membregroupe = array();
		foreach($this->model_groupe->getAllMembresGroupe($data['groupe'])->result() as $item){
			array_push($membregroupe, $item->emailUtilisateur);
		}
		
		if($data['groupe'] > 0) {
			if(empty($data['membre']))	{
				echo 'Erreur : Veuillez selectionez un membre.';
			}
			else	{
				if($this->model_membre->check_membre($data['membre'])) { 			//on verifie si le membre choisis fait partie de la DB
					if(in_array($data['membre'],$membregroupe)) {					//on verifie si le membre choisis fait deja partie du groupe
						echo 'Erreur : Le membre est déja présent dans le groupe.';
					}
					else {
						if($this->model_groupe->estAdministrateur($data['groupe'], $data['email'])) {
							if($this->model_groupe->ajouterMembre($data['groupe'], $data['membre'])) {
									$this->session->set_userdata('nbGroupesUtilisateur', $this->model_groupe->countGroupes($data['email']));
									echo 'Succès ! '.$data['membre'].' a été ajouter au groupe.';
								
							} else {
								echo 'Erreur : Membre incorrecte, veuillez selectionez un membre.';			
							}
						}
						else {
							//Si un membre invite un autre membre, alors on recupère l'email de ladmin du groupe
							foreach($this->model_groupe->getGroupeVisiteur($data['groupe'])->result() as $item) {
								$adminGroupe = $item->emailAdministrateur;
							}
							if($this->model_acces->nouvelleDemandeAccesGroupe($data['groupe'],$adminGroupe, $data['membre'])) {
									echo 'Succès ! Une demande de validation a été envoyer a l\'administrateur du groupe.';
								
							} else {
								echo 'Erreur : Membre incorrecte, veuillez selectionez un membre.';			
							}
						}
					}
				}
				else {
					echo 'Erreur : Le membre n\'existe pas, veuillez selectionez un membre.';
				}	
			}
		}
		else {
			echo 'Erreur : Veuillez selectionner un groupe.';
		}
	}
	
	
	/****************************************************/
	/* Méthode ajax										*/
	/*													*/
	/* BUT : 											*/
	/* afficher le formulaire pour éditer un groupe		*/
	/****************************************************/
	public function ajax_ecran_edition_groupe() {

		$data['email']	= $this->input->post('email');
		$data['groupe']	= $this->input->post('groupe');
		
		if($this->input->post('ajax') == '1' && $data['email'] == $this->session->userdata('email') && $data['groupe']) {

			if(!$this->model_groupe->estAdministrateur($data['groupe'], $data['email'])) {
				
				echo 'Action impossible. Vous n\'êtes pas administrateur.';	
				
			} else {
				
				$data['groupe'] = $this->model_groupe->getGroupe($data['groupe']);
				$this->load->view('groupe/vue_edition_groupe', $data);
				
			}
		} else {
			echo 'Erreur : Vous ne disposez pas des droits suiffisants pour quitter le groupe.';
		}

	}
	
	/****************************************************/
	/* Méthode ajax										*/
	/*													*/
	/* BUT : 											*/
	/* édition  un groupe								*/
	/****************************************************/
	public function ajax_edit_groupe() {
	
		$data['email']			= $this->session->userdata('email');
		$data['idGroupe']		= $this->input->post('idGroupe');
		$data['intitule']		= $this->input->post('intitule');
		$data['description']	= $this->input->post('description');
		
		if(	$this->input->post('ajax') == '1' && 
			$data['email'] != "" &&
			$data['idGroupe'] > 0 &&
			$data['intitule'] != "" &&
			$data['description'] != "" &&
			$this->model_groupe->estAdministrateur($data['idGroupe'], $data['email'])
		) {
			$donnees = array(	'intitule'		=> $data['intitule'],
								'description'	=> $data['description']
			);
			
			if( $this->model_groupe->updateGroupe($data['idGroupe'], $donnees) ) {
				echo "Succès : Les données du groupe ont correctement été mises à jour." ;
			} else {
				echo "Erreur : Il est impossible de modifier les informations du groupe.";	
			}
		} 
		else {
			echo "Erreur : Vous n'êtes pas autorisé à modifié les informations de ce groupe.";	
		}
	}

}