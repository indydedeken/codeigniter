<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Commentaire extends CI_Controller {

	public function index() {
		// rien
	}

	/************************************************/
	/* commentaire/add								*/
	/*												*/
	/* BUT : ajouter un commentaire en ajax			*/
	/************************************************/
	public function add() {
		
		if( $this->input->post('ajax') ) 
		{
			/* 
			 * Récupération des variables $_POST
			 */
			$idDocument			= $this->input->post('doc');
			$idGroupe			= $this->input->post('grp');
			$commentaire		= $this->input->post('commentaire');
			// variable faites maison
			$emailUtilisateur	= $this->session->userdata('email');
			$dateCreation		= mdate("%d/%m/%Y", time());
			
			$data = array(	'idDocument'		=> $idDocument,
							'idGroupe'			=> $idGroupe,
							'emailUtilisateur'	=> $emailUtilisateur, 
							'commentaire'		=> $commentaire,
							'dateCreation'		=> $dateCreation
			);
			
			$idCommentaire = '';
			
			// si le commentaire est nul :
			if( trim($commentaire) == "")
			{
				$status = 'error';
				$msg	= "Les commentaires vides n'ont pas d'intérêt :]";
			} 
			else 
			{		
				// ajout du commentaire
				if( $idCommentaire = $this->model_commentaire->addCommentaire($data) )
				{
					$status = 'success';
					$msg	= "Votre commentaire est ajouté !";
				} 
				else
				{
					$status = 'error';
					$msg	= 'Une erreur s\'est produite, veuillez réessayez s\il vous plait.';
				}
			}
		} 
		else
		{
			$status = 'error';
			$msg	= 'Accès non autorisé.';
		}
		
		// traitement termine, on envoi le status et le message de l operation 
	    echo json_encode(array(	'status' 		=> $status, 
								'msg' 			=> $msg, 
								'email'			=> $emailUtilisateur, 
								'date'			=> $dateCreation,
								'idCommentaire' => $idCommentaire, 
								'commentaire'	=> $commentaire,
								'idGroupe' 		=> $idGroupe, 
								'idDocument' 	=> $idDocument));
	}
}