<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
				if($this->model_membre->check_membre($this->input->post('email'), $this->input->post('mdp'))) {
					
					$data = $this->model_membre->get_membre($this->input->post('email'));
					foreach($data->result() as $item) {
						$email	= $item->email;
					}
					
					$data = array(
						'email'		=> $email,
						'logged'	=> true
					);
					
					$this->session->set_userdata($data);
					redirect(site_url().'home', $data);
					
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
			redirect(site_url().'home');	
		}
	}
	
	/****************************************/
	/* membre/register						*/
	/*										*/
	/* BUT : inscription d'un utilisateur	*/
	/****************************************/
	function register() {
		
		$data['nav'] = "membre"; 
		
		if(!$this->session->userdata('email') || !$this->session->userdata('logged')) {
		 
			/* 
			 *	Regles de validation du formulaire
			 *	Règles en +, exemples : callback_check_mailcallback_check_int');
			 *
			 * /!\ CHECKER QUE (MAIL + LOGIN) N'EXISTE PAS DÉJÀ /!\
			 *
			 */
			$this->form_validation->set_rules('nomInscription', 'nom', 'trim|xss_clean|required|min_length[2]|max_length[100]');
			$this->form_validation->set_rules('prenomInscription', 'prenom', 'trim|xss_clean|required|min_length[2]|max_length[100]');
			$this->form_validation->set_rules('mailInscription', 'e-mail', 'trim|required|xss_clean|valid_email');
			$this->form_validation->set_rules('passwordInscription1', 'mot de passe', 'trim|required|xss_clean|min_length[4]|max_length[15]');
			$this->form_validation->set_rules('passwordInscription2', ' vérification de mot de passe', 'trim|required|xss_clean|min_length[4]|max_length[15]|matches[passwordInscription1]');
			
			// si le formulaire est bien rempli
			if($this->form_validation->run() == TRUE) {
				
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

				// si l'on a besoin on place le nom dans $data pour l'utiliser
				//$data['email']	= $dataInscription['email'];
				//$data['nom']	= $dataInscription['nom'];
 				
				if($this->model_membre->check_membre($dataInscription['email'], $dataInscription['mdp'])) {
					
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
					$this->load->view('vue_inscription_succes', $data);
					$this->load->view('footer', $data);
					
				} else {
					// cas d'erreur
					// affichage des vues
					$this->load->view('header', $data);
					$this->load->view('vue_connexion', $data);
					$this->load->view('footer', $data);
				
				}
 				
 				
				
			
			} else {
				
				// affichage des vues
				$this->load->view('header', $data);
				$this->load->view('vue_connexion', $data);
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
		redirect(site_url()."membre");	// adresse a redéfinir, pas propre là
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