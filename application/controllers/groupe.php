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
			
			// afficher le nombre de document/groupe de l'utilisateur
			if($this->session->userdata('email')) {
				$data['nbDocumentsUtilisateur']	= $this->model_document->countDocuments($this->session->userdata('email'), 'tous');
				$data['nbGroupeUtilisateur']	= $this->model_groupe->countGroupes($this->session->userdata('email'));
				$data['groupe']	= $this->model_groupe->getAllGroupes($this->session->userdata('email'));
			}
			
			//$data['nbGroupes']				= $this->model_groupe->countGroupes($email, 'tous');
			
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
	/* BUT : afficher un groupe				*/
	/****************************************/
	public function afficher() {
		
		$data['nav'] = "afficher"; 
		
		// vérifier que l'utilisateur à le droit d'accès à ce document
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
		
		} else {
			redirect(site_url().'membre');	
		}
	}
}