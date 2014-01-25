<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * http://localhost:8888/codeigniter/index.php/home
	 */
	public function index()
	{
		/**
		 * Donner une valeur pour permettre, sur la vue 
		 * de charger tel ou tel script, selon le besoin. 
		 */
		$data['nav'] = "home"; 
		$data['id'] = $this->session->userdata('id');
		$data['email'] = $this->session->userdata('email');
		$data['logged'] = $this->session->userdata('logged');
		
		// afficher le nombre de document de l'utilisateur
		if($this->session->userdata('logged')) {
			$data['nbDocumentsUtilisateur']	= $this->model_document->countDocuments($this->session->userdata('email'), 'tous');
			$data['nbGroupeUtilisateur']	= $this->model_groupe->countGroupes($this->session->userdata('email'));
		}
		
		if($this->agent->is_mobile()) {
			//echo "Vue mobile";
			$this->load->view('header', $data);
			$this->load->view('home_message', $data);
			$this->load->view('footer', $data);
		} else {
			$this->load->view('header', $data);
			$this->load->view('home_message', $data);
			$this->load->view('footer', $data);
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */