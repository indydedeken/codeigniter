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
	/* document/gestion				*/
	/*						*/
	/* BUT : gestion des document d'un utilisateur	*/
	/************************************************/
	public function gestion() {
		
		$data['nav'] = "gestionDoc"; 
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$email = $this->session->userdata('email');
			
			$data['groupes']		= $this->model_groupe->getAllGroupes($email);
			$data['documents']		= $this->model_document->getAllDocuments($email);
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
	/* document/afficher/<idDocument>	*/
	/*					*/
	/* BUT : afficher un document		*/
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
				
				//$data['document'] 		= $this->model_document->getDocument($id, $this->session->userdata('email'));
				//$data['estAdministrateur'] 	= $this->model_document->estAdministrateur($id, $this->session->userdata('email'));
				$data['idDocument']		= $idDocument;

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
	
	/****************************************/
	/* document/creer/			*/
	/*					*/
	/* BUT : formulaire d'upload de document*/
	/* 		 			*/
	/****************************************/
	public function creer() {
		
		//$data['nav'] = "creer"; 
		
		// vérifier que l'utilisateur à le droit d'accès
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$data = "";
			
			$this->load->view('header', $data);
			$this->load->view('document/vue_creer_document', $data);
			$this->load->view('footer', $data);
			
		} else {
			redirect(site_url().'membre');
		}
	}
	
	/****************************************/
	/* document/upload/			*/
	/*					*/
	/* BUT : upload de document		*/
	/* 		 			*/
	/****************************************/
	public function upload() {
		if($this->session->userdata('email') && $this->session->userdata('logged'))  {
			// paramétrage des règles d'upload
			$config['upload_path'] 		= './fileUploaded/'; // personnaliser le dossier de réception...
			$config['allowed_types'] 	= 'pdf';
			$config['max_filename']		= '255';
			$config['remove_spaces'] 	= 'true';
			$config['overwrite']		= 'FALSE';
			//$config['max_size']		= '10000';
			
			$this->load->library('upload', $config);
			
			$data = array(); 
			
			if ( ! $this->upload->do_upload() )
			{
				// consulter les erreurs
				//$data = array('error' => $this->upload->display_errors());
				
				//si l'upload échoue on redirige vers la page d'upload de document
				redirect(site_url().'document/creer');
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				// ['raw_name']	 = nom_du_fichier
				// ['orig_name'] = nom_du_fichier.pdf
				
				if( $data['upload_data']['raw_name'] != '' ) {
					$titreFichier = str_ireplace("_", " ", $data['upload_data']['raw_name']);
					
					if ($this->input->post('titre'))
						$titre = $this->input->post('titre');
					else	$titre = $titreFichier;
					if ($this->input->post('auteur'))
						$auteur = $this->input->post('auteur');
					else	$auteur = "";
					if ($this->input->post('description'))
						$description = $this->input->post('description');
					else	$description = "";
					
					// préparation des variables pour la creation du groupe
					$donnees['emailUtilisateur']	= $this->session->userdata('email');
					$donnees['titre'] 		= $titre;
					$donnees['auteur']		= $auteur;
					$donnees['description'] 	= $description;
					$donnees['contenuOriginal']	= '<html>mon contenu original bla bla</html>'; // reception du pdf>html
					$donnees['etat']		= 0;
					$donnees['dateCreation'] 	= mdate("%d/%m/%Y", time());
					// insertion du document en DB
					$idDocument = $this->model_document->addDocument('Document', $donnees);
					
					$donneesDocGrp['idGroupe']	= 0; // groupe 0 est document personnel
					$donneesDocGrp['idDocument']	= $idDocument;
					$this->model_groupe->addDocGroupe($donneesDocGrp);
					
					if($idDocument>0) {
						$this->load->view('header', $data);
						$this->load->view('document/vue_creer_document_succes', $data);
						$this->load->view('footer', $data);
					} else {
						$this->load->view('header', $data);
						echo "erreur";
						$this->load->view('footer', $data);
					}
				}
			}
		}		
	}

	/********************************************************/
	/* membre/profil					*/
	/*							*/
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
	/* membre/ajax_info_profil					*/
	/*								*/
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
	/* membre/logout 			*/
	/*					*/
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