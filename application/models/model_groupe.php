<?php 

class Model_groupe extends CI_Model {
	
	/*
	 * Model_groupe
	 */
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	// ajouter un groupe
	public function addGroupe($data) {
			$this->db->insert('Groupe', $data);
	}
	
	/* countGroupes		: connaitre le nombre de Groupes disponible
	 * param1 			: email de l'utilisateur, peut-être vide
	 * return			: nombre de Groupes qui correspondent
	 */
	public function countGroupes($email) {
		
		if($email != '')
			$this->db->like('emailUtilisateur', $email);
		
		$data = $this->db->count_all_results('GroupeUtilisateur');
		
		return $data;	
	}
	
	/* getAllGroupes	: récupérer tous les Groupes d'un utilisateur
	 * param1			: email de l'utilisateur
	 * return			: ensemble des données de chaque Groupe
	 */
	public function getAllGroupes($email) {
				
		$param = array('emailUtilisateur' => $email);
		
		$this->db->select('*');
		$this->db->join('GroupeUtilisateur', 'GroupeUtilisateur.idGroupe = Groupe.id');
		$data = $this->db->get_where('Groupe', $param);
		
		return $data;
	}
	
	/* getGroupe	: récupérer un Groupe
	 * param1		: id du Groupe
	 * param2		: email de l'utilisateur
	 * return		: ensemble des données du Groupe
	 */
	public function getGroupe($idGroupe, $email) {
		$this->db->select('*');
		$param = array(	'id'	=> $idGroupe,
						'email'	=> $email
		);
		$data = $this->db->get_where('Groupe', $param);
		if($data->num_rows() == 1) {
			return $data;
		} else {
			return false;	
		}
	}
	
	/*
	 * delGroupe	: supprimer un Groupe
	 * param1		: id du Groupe
	 * param2		: email de l'utilisateur
	 * return		: true
	 */
	 public function delGroupe($idGroupe, $email) {
		$param = array(	'id'	=> $idGroupe,
						'email'	=> $email 
		);
	 	if($this->db->delete('Groupe', $param))
			return true;
		else
			return false;		 	
	 }
	 
	 /*
	 * delGroupeAnnexe	: supprimer un Groupe dans les autres tables que Groupe
	 * param1				: id du Groupe
	 * return				: true
	 */
	 /* BUG SI DECOMMENTER, A CORRIGER + tard
	 public function delGroupe($idGroupe) {
		$table = array('GroupeGroupe', 'Annotation');
		$param = array(	'idGroupe' => $idGroupe);
	 	if($this->db->delete($table, $param))
			return true;
		else
			return false;		 	
	 }
	 */
}