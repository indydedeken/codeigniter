<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

			if($this->model_groupe->getGroupe($idGroupe, $this->session->userdata('email'))) {
				
				$data['groupe'] 			= $this->model_groupe->getGroupe($idGroupe, $this->session->userdata('email'));
				$data['membresGroupe'] 		= $this->model_groupe->getAllMembresGroupe($idGroupe);
				$data['estAdministrateur'] 	= $this->model_groupe->estAdministrateur($idGroupe, $this->session->userdata('email'));
				$data['idGroupe']			= $idGroupe;
				$data['documents']			= $this->model_document->getAllDocumentsGroupe($idGroupe, $this->session->userdata('email'));
				
				$this->load->view('header', $data);
				$this->load->view('groupe/vue_afficher_groupe', $data);
				$this->load->view('footer', $data);
			
			} else {
				// affichage d'une page d'erreur

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
				
				$donneesGroupe = array(	'intitule'				=> $donnees['nom'],
										'description'			=> $donnees['description'],
										'dateCreation'			=> $donnees['dateCreation'],
										'emailAdministrateur'	=> $donnees['emailAdministrateur']
				);
				
				// insertion du groupe en DB
				$idGroupe = $this->model_groupe->addGroupe('Groupe', $donneesGroupe);
				
				if( $idGroupe > 0 ) {
					// ajouter les documents	
					$data['idGroupe'] = $idGroupe;
					$data['creation'] = 1;
					$data['nom'] = $this->input->post('nom');
					$data['description'] = $this->input->post('description');
				}
				
				// insertion de l'utilisateur au groupe
				$donneesGroupeUtilisateur = array(	'idGroupe'				=> $idGroupe,
													'emailUtilisateur'		=> $this->session->userdata('email'),
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
			echo 'Erreur : Vous ne disposez pas des droits suiffisants pour quitter le groupe.';
		}

	}
}