<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Membre extends CI_Controller {

	public function index() {
		// vérifier que l'utilisateur est connecté
		if(	!$this->session->userdata('logged') || 
			!$this->session->userdata('login')) 
		{
			redirect(site_url().'index.php/membre/signin');
		} 
		else 
		{
			redirect('index.php/home');
		}
	}

	/************************************/
	/* membre/signin					*/
	/*									*/
	/* BUT : connexion d'un utilisateur	*/
	/************************************/
	public function signin() {
		
		$data['nav'] = "membre"; 
		
		if(!$this->session->userdata('login') || ! $this->session->userdata('logged')) {
			
			// regles de validation du formulaire
			$this->form_validation->set_rules('login', 'login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('mdp', 'mot de passe', 'trim|required|xss_clean');
			
			// si le formulaire est bien rempli
			if($this->form_validation->run() == TRUE) {
				
				// si les identifiants sont corrects
				// on peut convertir le mdp en sha1(...)
				if($this->model_compte->check_membre($this->input->post('login'), $this->input->post('mdp'))) {
					
					$data = $this->model_compte->get_membre($this->input->post('login'));
					foreach($data->result() as $item) {
						$id = $item->id;
						$login = $item->login;
					}
		
					$data = array(
						'id'		=> $id,
						'login' 	=> $login, 
						'logged'	=> true
					);
					
					$this->session->set_userdata($data);
					redirect(site_url().'index.php/home', $data);
					
				} else {
			
					$data['error'] = '<span class="label label-warning">Mauvais identifiants</span><br>';
					
					if($this->agent->is_mobile()) {
						$this->load->view('header');
						$this->load->view('vue_connexion', $data);
						$this->load->view('footer');
					} else {
						$this->load->view('header');
						$this->load->view('vue_connexion', $data);
						$this->load->view('footer');			
					}
				}
			
			} else {
				
				$this->load->view('header', $data);
				$this->load->view('vue_connexion', $data);
				$this->load->view('footer', $data);
			}
		} else {
			redirect(site_url().'index.php/home');	
		}
	}
	
	/****************************************/
	/* membre/register						*/
	/*										*/
	/* BUT : inscription d'un utilisateur	*/
	/****************************************/
	function register() {
		
		$data['nav'] = "membre"; 
		
		if(!$this->session->userdata('login') || ! $this->session->userdata('logged')) {
		
			// regles de validation du formulaire
			$this->form_validation->set_rules('mailPerso', 'e-mail', 'trim|required|xss_clean|valid_email|callback_check_mail');
			$this->form_validation->set_rules('mailPro', 'e-mail pro', 'trim|xss_clean|valid_email');
			$this->form_validation->set_rules('mdpConf', 'mot de passe confirmation', 'trim|required|xss_clean|min_length[4]|max_length[15]');
			$this->form_validation->set_rules('anneePromo', 'année', 'trim|required|xss_clean|min_length[4]|max_length[4]|callback_check_int');
			$this->form_validation->set_rules('mdp', 'mot de passe', 'trim|required|xss_clean|min_length[4]|max_length[15]|matches[mdpConf]');
			$this->form_validation->set_rules('nom', 'nom', 'trim|xss_clean|required');
			$this->form_validation->set_rules('prenom', 'prenom', 'trim|xss_clean|required');
			$this->form_validation->set_rules('ville', 'coordonnées', 'xss_clean');
			
			// si le formulaire est bien rempli
			if($this->form_validation->run() == TRUE) {
				
				$data = array(
					'mailPerso'	=> $this->input->post('mailPerso'),
					'mdp'		=> sha1($this->input->post('mdp')),
					'anneePromo'=> $this->input->post('anneePromo'),
					'promo'		=> 'DUT', // car la promo est forcement un DUT
					'nom'		=> $this->input->post('nom'),
					'prenom'	=> $this->input->post('prenom'),
					'ville'		=> $this->input->post('ville'),
					'mailPro'	=> $this->input->post('mailPro'),
					'etatCivil'	=> $this->input->post('etatCivil')
				);
				
				// insertion en db
				$this->load->model('model_membre');
				$this->model_membre->ajout_membre($data);
				
				// recuperation du membre
				$id = $this->model_membre->get_membre($data['mailPerso']);
				foreach($id->result() as $item) {
						$id = $item->id;
				}
				
					// IUT SF est l'étab avec id=1, DUT INFO est diplome avec id=1
				$this->model_membre->gestion_cursus("enregistrer", $id, 1, 1, $data['anneePromo']);
				
				// affichage des vues
				$this->load->view('header');
				$this->load->view('vue_inscription_succes');
				$this->load->view('footer');
			
			} else {
	
				// affichage des vues
				$this->load->view('header', $data);
				$this->load->view('vue_inscription', $data);
				$this->load->view('footer', $data);
			}
		} else {
			redirect(site_url().'membre');	
		}
	}


	/****************************************/
	/* membre/logout 						*/
	/*										*/
	/* BUT : déconnexion d'un utilisateur	*/
	/****************************************/
	function logout() { 
	
		// supprimer les variables de session	
		$this->session->set_userdata('id');
		$this->session->set_userdata('login');
		$this->session->set_userdata('logged');

		$this->session->sess_destroy();
		redirect(site_url()."index.php/membre");	// adresse a redéfinir, pas propre là
	}

	
/*************************************************/
/************* FONCTIONS DE CALLBACK *************/
/*************************************************/
	
	/*************************************/
	/* vérifie l'existance du mail en DB */
	/*************************************/
	function check_mail(){
		if($this->input->post('mail')) {
			$this->db->select('mail');
			$this->db->from('membre');
			$this->db->where('mail', $this->input->post('mail'));
			if($this->db->count_all_results()>0) {
				$this->form_validation->set_message('check_mail', 'Ce mail existe déjà !');	
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