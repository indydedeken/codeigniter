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
			$this->load->view('vue_gestion_groupe', $data);
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
			
			$id = $this->uri->segment(3);

			if($this->model_groupe->getGroupe($id, $this->session->userdata('email'))) {
				
				$data['groupe'] 			= $this->model_groupe->getGroupe($id, $this->session->userdata('email'));
				$data['membresGroupe'] 		= $this->model_groupe->getAllMembresGroupe($id);
				$data['estAdministrateur'] 	= $this->model_groupe->estAdministrateur($id, $this->session->userdata('email'));
				$data['idGroupe']			= $id;

				$this->load->view('header', $data);
				$this->load->view('vue_afficher_groupe', $data);
				$this->load->view('footer', $data);
			
			} else {
				// affichage d'une page d'erreur

				$this->load->view('header', $data);
				$this->load->view('vue_afficher_groupe_inaccessible', $data);
				$this->load->view('footer', $data);
			}	

		} else {
			redirect(site_url().'membre');	
		}
	}

	public function ajax_quitte_groupe() {

		$data['email']	= $this->input->post('email');
		$data['groupe']	= $this->input->post('groupe');

		if($this->input->post('ajax') == '1' && $data['email'] == $this->session->userdata('email') && $data['groupe']) {

			// vérifier que l'utilisateur à le droit de quitter le groupe...
			// regles de gestion............................................
			
			if($this->model_groupe->quitterGroupe($data['groupe'], $data['email'])) {
			
				$this->session->set_userdata('nbGroupesUtilisateur', $this->model_groupe->countGroupes($data['email']));
				echo 'Succès : Vous avez bien quitté le groupe.';
			
			} else {
				echo 'Erreur : Vous ne pouvez pas quitter le groupe.';			
			}
		
		} else {
			echo 'Erreur : Vous ne disposez pas des droits suiffisants pour quitter le groupe.';
		}

	}
}