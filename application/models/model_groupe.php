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

		// récupère toutes les variables du groupe + nombre de collaborateur
		$this->db->select('*, count(*) as nb');
		$this->db->from('Groupe JOIN GroupeUtilisateur ON `GroupeUtilisateur`.`idGroupe` = `Groupe`.`id` ');
		$this->db->where('Groupe.id IN (select idGroupe from GroupeUtilisateur WHERE emailUtilisateur = \''.$email.'\')');
		$this->db->group_by('id');
		$data = $this->db->get();

		return $data;
	}
	
	/* getGroupe	: récupérer un Groupe
	 * param1		: id du Groupe
	 * param2		: email de l'utilisateur
	 * return		: ensemble des données du Groupe
	 */
	public function getGroupe($idGroupe, $email) {
		$param = array(	'id'				=> $idGroupe,
						'emailUtilisateur'	=> $email
		);
		
		$this->db->join('GroupeUtilisateur', 'GroupeUtilisateur.idGroupe = Groupe.id');
		$data = $this->db->get_where('Groupe', $param);
		
		if($data->num_rows() == 1) {
			return $data;
		} else {
			return false;	
		}
	}
	
	/*
	 * getAllMembresGroupe	: obtenir tous les membres d'un Groupe 
	 * param1				: id du Groupe
	 * param2				: email de l'utilisateur
	 * return				: array de membre
	 */
	public function getAllMembresGroupe($idGroupe) {
		$this->db->select('*');
		$this->db->from('`GroupeUtilisateur` JOIN `Utilisateur` ON `GroupeUtilisateur`.`emailUtilisateur` = `Utilisateur`.`email`');
		$this->db->where('idGroupe', $idGroupe);
		$this->db->order_by('dateInscriptionGroupe', 'desc');
		$data = $this->db->get();

		return $data;
	}

	/*
	 * estAdministrateur	: savoir si un membre est admin du groupe
	 * param1				: id du Groupe
	 * param2				: email de l'utilisateur
	 * return				: true/false
	 */
	public function estAdministrateur($idGroupe, $email) {
		$param = array(	'id' 					=> $idGroupe,
						'emailAdministrateur'	=> $email
		);

		$data = $this->db->get_where('Groupe', $param);

		if($data->num_rows() == 1) {
			return true;
		} else {
			return false;	
		}
	}

	public function quitterGroupe($idGroupe, $email) {
		$param = array('idGroupe' 			=> $idGroupe,
						'emailUtilisateur'	=> $email
		);
		
		if($this->db->delete('GroupeUtilisateur', $param))
			return true;
		else
			return false;

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