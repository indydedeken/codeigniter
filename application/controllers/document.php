<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Document extends CI_Controller {

	public function index() {
		// vérifier que l'utilisateur est connecté
		if(	$this->session->userdata('logged') && $this->session->userdata('email')) 
		{
			redirect(site_url().'document/gestion');
		} 
		else 
		{
			redirect('membre/register');
		}
	}

	/************************************************/
	/* document/gestion								*/
	/*												*/
	/* BUT : gestion des document d'un utilisateur	*/
	/************************************************/
	public function gestion() {
		
		$data['nav'] = "gestionDoc"; 
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$email = $this->session->userdata('email');
			
			$data['groupes']				= $this->model_groupe->getAllGroupes($email);
			$data['documents']				= $this->model_document->getAllDocuments($email);
			//$data['nbGroupeUtilisateur']	= $this->model_groupe->countGroupes($email);
			
			$this->load->view('header', $data);
			$this->load->view('document/vue_gestion_document', $data);
			$this->load->view('footer', $data);
		
		} else {
			// si non loggé && sans email
			redirect(site_url().'home');	
		
		}
	}
	
	/****************************************/
	/* document/afficher/<idDocument>		*/
	/*										*/
	/* BUT : afficher un document			*/
	/****************************************/
	public function afficher() {
		
		$data['nav'] = "afficher"; 
		
		// vérifier que l'utilisateur à le droit d'accès à ce document
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$idDocument = $this->uri->segment(3);
			$idGroupe = $this->uri->segment(5);
			if($idGroupe == NULL)
				$idGroupe = -1;
				
						
			if($this->model_document->getDocument($idDocument, $this->session->userdata('email'), $idGroupe)) {
				
				//$data['document'] 			= $this->model_document->getDocument($id, $this->session->userdata('email'));
				//$data['estAdministrateur'] 	= $this->model_document->estAdministrateur($id, $this->session->userdata('email'));
				$data['idDocument']			= $idDocument;

				$this->load->view('header', $data);
				$this->load->view('document/vue_afficher_document', $data);
				$this->load->view('footer', $data);
			
			} else {
				// affichage d'une page d'erreur

				$this->load->view('header', $data);
				$this->load->view('document/vue_afficher_document_inaccessible', $data);
				$this->load->view('footer', $data);
			}	

		} else {
			redirect(site_url().'membre');	
		}
	}


	/********************************************************/
	/* membre/profil										*/
	/*														*/
	/* BUT : administration des variables d'un utilisateur	*/
	/********************************************************/
	public function profil() {
		if($this->session->userdata('email') && $this->session->userdata('logged'))  {
			$data['nav'] = 'profil';
			
			// remettre nav=membre car on refait le tableau
			$data['nav'] = "membre"; 
			
			$this->session->set_userdata($data);
			
			// affichage des vues
			$this->load->view('header', $data);
			$this->load->view('membre/vue_profil', $data);
			$this->load->view('footer', $data);
				
		} else {
			redirect(site_url().'membre/register');
		}
	}
	
	
	/****************************************************************/
	/* membre/ajax_info_profil										*/
	/*																*/
	/* BUT : mettre à jour le formulaire des données utilisateur	*/
	/****************************************************************/
	public function ajax_info_profil() {
		if($this->input->post('ajax') == '1') {
			
			$this->form_validation->set_rules('nom', 'nom', 'trim|required|xss_clean');
			$this->form_validation->set_rules('prenom', 'prenom', 'trim|required|xss_clean');
			
			$this->form_validation->set_message('required', 'Erreur : Merci de saisir tous les champs !');
			if($this->form_validation->run() == FALSE) {
				// message d'erreur
				echo validation_errors();
				
			} else {
				// mise à jour des données
				$data['nom'] 	= $this->input->post('nom');
				$data['prenom'] = $this->input->post('prenom');
				$this->model_membre->maj_info_unite($data);
				// mise à jour des var de session
				$this->session->set_userdata($data);
				echo 'Succès : Données utilisateur mises à jour';
			}
		}
	}

	/****************************************/
	/* membre/logout 						*/
	/*										*/
	/* BUT : déconnexion d'un utilisateur	*/
	/****************************************/
	function logout() { 
	
		// supprimer les variables de session	
		$this->session->set_userdata('nom');
		$this->session->set_userdata('prenom');
		$this->session->set_userdata('email');
		$this->session->set_userdata('logged');

		$this->session->sess_destroy();
		redirect(site_url()."membre");	// adresse a redéfinir, pas propre là
	}

	
/*************************************************/
/************* FONCTIONS DE CALLBACK *************/
/*************************************************/
	
	/*************************************/
	/* vérifie l'existance du mail en DB */
	/*************************************/
	function check_mail(){
		if($this->input->post('mailInscription')) {
			$this->db->select('email');
			$this->db->from('Utilisateur');
			$this->db->where('email', $this->input->post('mailInscription'));
			if($this->db->count_all_results()>0) {
				$this->form_validation->set_message('check_mail', 'Cette adresse email est déjà utilisée !');	
				return false;
			} else {
				return true; 	
			}
		}
	}
	
	/************************************/
	/* vérifie qu'il s'agit d'une année */
	/************************************/
	function check_int(){
		if(ctype_digit($this->input->post('annee'))) {
			return true;
		} else {
			$this->form_validation->set_message('check_int', 'Saisir une année. Ex : 2010,2011,2012...');	
			return false;
		}
	}
}