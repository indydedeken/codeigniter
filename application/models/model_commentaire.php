<?php 

class Model_commentaire extends CI_Model {
	
	/*
	 * Model_commentaire
	 * Utilisation de tout ce qui concerne les commentaires
	 */
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	/* addComentaire	: ajouter un commentaire
	 * param1			: data a inserer
	 * return 			: id du commentaire ajoute
	 */
	public function addCommentaire($data) {
		
		$this->db->trans_begin();	
		
		if( $this->db->insert('Commentaire', $data) ) {
			// si l'insertion réussie
			$insert_id = $this->db->insert_id();
			$this->db->trans_commit();
		} else {
			// si l'insertion échoue
			$this->db->trans_rollback();
			return 0;
		}	
		
		// retour de la fonction en cas de réussite
		return $insert_id;
	}
	
	/* delComentaire	: supprimer un commentaire
	 * param1			: data (contrainte)
	 * return 			: true/false
	 */
	public function delCommentaire($data) {
		
		$this->db->trans_begin();
		
		// contrainte pour la suppression
		$this->db->where($data);
		
		if( $this->db->delete('Commentaire') ) {
			// si la suppression est réussie
			$insert_id = $this->db->insert_id();
			$this->db->trans_commit();
		} else {
			// si l'insertion échoue
			$this->db->trans_rollback();
			return 0;
		}	
		// retour de la fonction en cas de réussite
		return 1;
	}
	
	/* updateComentaire	: maj un commentaire
	 * param1			: data à mettre à jour
	 * return 			: true/false
	 */
	public function updateCommentaire($data) {
		
		$this->db->trans_begin();
		
		if( $this->db->update('Commentaire', $data) ) {
			// si la suppression est réussie
			$insert_id = $this->db->insert_id();
			$this->db->trans_commit();
		} else {
			// si l'insertion échoue
			$this->db->trans_rollback();
			return 0;
		}	
		// retour de la fonction en cas de réussite
		return 1;
	}

	/* getComentaire	: obtenir les commentaires d'un document
	 * param1			: data (contraintes)
	 * return 			: $commentaires
	 */
	public function getCommentaire($param) {

		// DANS L'IDEAL, IL FAUDRAIT VÉRIFIER QUE 
		// L'UTILISATEUR A ACCES AU DOCUMENT
		
		$data = $this->db->order_by('id', 'DESC')->get_where('Commentaire', $param);

		if($data) {
			return $data->result();
		} else {
			return array();	
		}
	}
	
	/* countCommentairesGroupe	: compter l'activité commentaire d'un groupe
	 * param1					: param (contraintes)
	 * return 					: nombre de commentaire
	 */
	public function countCommentaires($param) {

		// DANS L'IDEAL, IL FAUDRAIT VÉRIFIER QUE 
		// L'UTILISATEUR A ACCES AU DOCUMENT
		
		$data = $this->db->get_where('Commentaire', $param);

		if($data) {
			return $data->num_rows();
		} else {
			return 0;	
		}
	}
}