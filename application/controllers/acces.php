<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Acces extends CI_Controller {
	
	public function index() {
		// vérifier que l'utilisateur est connecté
		if(	$this->session->userdata('logged') && $this->session->userdata('email')) 
		{
			$data = array();
			
			$data['groupes']['wait']	= $this->model_acces->getGroupeWait($this->session->userdata('email'));
			$data['groupes']['ok']		= $this->model_acces->getGroupeOK($this->session->userdata('email'));
			$data['groupes']['ko']		= $this->model_acces->getGroupeKO($this->session->userdata('email'));
			
			$data['groupesPerso']		= $this->model_acces->getMembresAValider($this->session->userdata('email'));
			
			
			$this->load->view('header', $data);
			$this->load->view('acces/vue_acces_global', $data);
			$this->load->view('footer', $data);
		} 
		else 
		{
			redirect('membre/register');
		}
	}
	
	/****************************************************/
	/* acces/demande/param1/<a>/param2/<b>/param3/<c>	*/
	/*													*/
	/*	ATTENTION - les adresses mails dans l'url : "@" est remplacé par "-" */
	/*													*/
	/* BUT : 				*/
	/****************************************************/
	public function demande() {
		
		if ($this->session->userdata('email') && $this->session->userdata('logged')) {
		
			$data['nav'] = "demandeAcces"; 
			
			$param = $this->uri->uri_to_assoc();
			
			// vérification des variables en parametre de la page
			if (isset($param['param1']) && isset($param['param2']) && isset($param['param3'])
				&& $param['param1'] != "" && $param['param2'] != "" && $param['param3'] != ""
			) {
				$idGroupe				= $param['param1'];
				$emailAdministrateur	= str_replace("-", "@", $param['param2']);
				$emailUtilisateur		= str_replace("-", "@", $param['param3']);
			} else {
				redirect(site_url().'home');
			}
			
			$requete = $this->model_acces->nouvelleDemandeAccesGroupe(	$idGroupe, 
																		$emailAdministrateur, 
																		$emailUtilisateur);
			
			if($requete > 0)
			{
				$this->load->view('header', $data);
				$this->load->view('acces/vue_acces_demande', $data);
				$this->load->view('footer', $data);
			} else 
			{
				$this->load->view('header', $data);
				echo "controller/acces.php --> echec de la requete...";
				$this->load->view('footer', $data);
			}
		} else {
			// si non loggé && sans email
			redirect(site_url().'home');
		}
	}
	
	/************************************************/
	/* acces/validation								*/
	/*												*/
	/* BUT : valider ou non l'acces d'un membre		*/
	/************************************************/
	public function validation() {
		/*
		$data['nav'] = "validationAcces"; 
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$idGroupe = $this->uri->segment(3);
			
			$this->load->view('header', $data);
			echo "idGroupe:" . $idGroupe . "<br>";
			//$this->load->view('document/vue_gestion_document', $data);
			$this->load->view('footer', $data);
		
		} else {
			// si non loggé && sans email
			redirect(site_url().'home');
		}*/
	}
}