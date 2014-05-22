<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Membre extends CI_Controller {

	public function index() {
		// vérifier que l'utilisateur est connecté
		if(	!$this->session->userdata('logged') || 
			!$this->session->userdata('email')) 
		{
			redirect(site_url().'membre/signin');
		} 
		else 
		{
			redirect('home');
		}
	}

	/************************************/
	/* membre/signin					*/
	/*									*/
	/* BUT : connexion d'un utilisateur	*/
	/************************************/
	public function signin() {
		
		$data['nav'] = "membre"; 
		if(!$this->session->userdata('email') || !$this->session->userdata('logged')) {
			
			// regles de validation du formulaire
			$this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('mdp', 'mot de passe', 'trim|required|xss_clean');
			
			// si le formulaire est bien rempli
			if($this->form_validation->run() == TRUE) {
				
				// si les identifiants sont corrects
				// on peut convertir le mdp en sha1(...)
				if( $this->model_membre->check_membre($this->input->post('email'), $this->input->post('mdp'))) {
					
					$data = $this->model_membre->get_membre($this->input->post('email'));
					foreach($data->result() as $item) {
						$email	= $item->email;
						$nom	= $item->nom;
						$prenom	= $item->prenom;
					}
					
					$data = array(
						'email'						=> $email,
						'prenom'					=> $prenom,
						'nom'						=> $nom,
						'logged'					=> true,
						'nbDocumentsUtilisateur'	=> $this->model_document->countDocuments($email, 'tous'),
						'nbGroupesUtilisateur'		=> $this->model_groupe->countGroupes($email)
					);
					
					
					$this->session->set_userdata($data);
					
					/*
					 * Ici on utilise la variable de session, car CI ne permet pas
					 * de récupérer un array dans une variable de session
					 */
					$_SESSION['listeTopDocuments']	= $this->model_document->getTopDocuments($this->session->userdata('email'), 3)->result();
					$_SESSION['listeTopGroupes']	= $this->model_groupe->getTopGroupes($this->session->userdata('email'), 3)->result();
					
					$_SESSION['listeGroupes']		= $this->model_groupe->getGroupes()->result();
					$_SESSION['listeDocuments']		= $this->model_document->getDocuments()->result();
					
					redirect(site_url().'home', $data);
					
				} else {
			
					
			
					$data['error'] = '<span class="label label-warning">Mauvais identifiants</span><br>';
					
					if($this->agent->is_mobile()) {
						$this->load->view('header');
						$this->load->view('membre/vue_connexion', $data);
						$this->load->view('footer');
					} else {
						$this->load->view('header');
						$this->load->view('membre/vue_connexion', $data);
						$this->load->view('footer');			
					}
				}
			
			} else {
				
				$this->load->view('header', $data);
				$this->load->view('membre/vue_connexion', $data);
				$this->load->view('footer', $data);
			}
		} else {
			redirect(site_url().'home');	
		}
	}
	
	/****************************************/
	/* membre/register						*/
	/*										*/
	/* BUT : inscription d'un utilisateur	*/
	/****************************************/
	public function register() {
		
		$data['nav'] = "membre"; 
		
		if(!$this->session->userdata('email') || !$this->session->userdata('logged')) {
		 
			/* 
			 *	Regles de validation du formulaire
			 *	Règles en +, exemples : callback_check_mail callback_check_int');
			 *
			 * /!\ CHECKER QUE (MAIL + LOGIN) N'EXISTE PAS DÉJÀ /!\
			 *
			 */
			$this->form_validation->set_rules('nomInscription', 'nom', 'trim|xss_clean|required|min_length[2]|max_length[100]');
			$this->form_validation->set_rules('prenomInscription', 'prenom', 'trim|xss_clean|required|min_length[2]|max_length[100]');
			$this->form_validation->set_rules('mailInscription', 'e-mail', 'trim|required|xss_clean|valid_email|callback_check_mail');
			$this->form_validation->set_rules('passwordInscription1', 'mot de passe', 'trim|required|xss_clean|min_length[4]|max_length[15]');
			$this->form_validation->set_rules('passwordInscription2', ' vérification de mot de passe', 'trim|required|xss_clean|min_length[4]|max_length[15]|matches[passwordInscription1]');
			
			// si le formulaire est bien rempli
			if( $this->form_validation->run() == TRUE ) {
				$dataInscription = array(
					'nom'	=> $this->input->post('nomInscription'),
					'prenom'=> $this->input->post('prenomInscription'),
					'email'	=> $this->input->post('mailInscription'),
					'mdp'	=> $this->input->post('passwordInscription1')
				);
				
				// insertion en db
				$this->load->model('model_membre');
				$this->model_membre->ajout_membre($dataInscription);
				
				// PAS NECESSAIRE... A VOIR....recuperation de l'id du membre
/*				$id = $this->model_membre->get_membre($data['mail']);
				foreach($id->result() as $item) {
						$id = $item->id;
				}
*/				

				if( $this->model_membre->check_membre($dataInscription['email']) ) {
					
					$data = $this->model_membre->get_membre($dataInscription['email']);
					foreach($data->result() as $item) {
						$email	= $item->email;
						$nom 	= $item->nom;
						$prenom	= $item->prenom;
					}
					
					$data = array(
						'email'		=> $email,
						'nom'		=> $nom,
						'prenom'	=> $prenom,
						'logged'	=> true
					);
					
					// remettre nav=membre car on refait le tableau
					$data['nav'] = "membre"; 
					
					$this->session->set_userdata($data);
					
					// affichage des vues
					$this->load->view('header', $data);
					$this->load->view('membre/vue_inscription_succes', $data);
					$this->load->view('footer', $data);
					
				} else {
					// cas d'erreur
					// affichage des vues
					$this->load->view('header', $data);
					$this->load->view('membre/vue_connexion', $data);
					$this->load->view('footer', $data);
				
				}
 				
			} else {
				
				// affichage des vues
				$this->load->view('header', $data);
				$this->load->view('membre/vue_connexion', $data);
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
				$this->model_membre->maj_info_unite($this->session->userdata('email'), $data);
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
		unset($_SESSION['listeTopDocuments']);
		unset($_SESSION['listeTopGroupes']);

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
	/* MODELE vérifie qu'il s'agit d'une année MODELE */
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