<?php 

class Model_groupe extends CI_Model {
	
	/*
	 * Model_groupe
	 */
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
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
	
	/* A REFAIRE getTopGroupe		: récupérer les top groupes
	 * A REFAIRE param1			: email de l'utilisateur
	 * A REFAIRE return			: ensemble des données de chaque Groupe
	 */
	public function getTopGroupes($email, $limite = NULL) {
		if($limite == NULL)
			$limite = 5;

		$this->db->select('*, count(*) as nb');
		$this->db->from('Groupe JOIN GroupeUtilisateur ON `GroupeUtilisateur`.`idGroupe` = `Groupe`.`id` ');
		$this->db->where('Groupe.id IN (select idGroupe from GroupeUtilisateur WHERE emailUtilisateur = \''.$email.'\')');
		$this->db->group_by('id');
		$this->db->order_by('id', 'desc');
		$data = $this->db->get('', $limite);

		return $data;
	}
	
	/* getGroupes	: récupérer tous les groupes existant
	 * return		: ensemble des données de chaque Groupe
	 */
	public function getGroupes() {
		// récupère toutes les variables du groupe + nombre de collaborateur
		$this->db->select('*');
		$this->db->from('Groupe');
		$this->db->group_by('id');
		$data = $this->db->get();

		return $data;
	}
	
	
	/* getAllGroupes	: récupérer tous les groupes d'un utilisateur
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
	
	/* getGroupe	: récupérer les informations d'un groupe
	 * param1		: id du Groupe
	 * return		: ensemble des données du Groupe
	 */
	public function getGroupe($idGroupe) {
		$param = array(	'id' => $idGroupe);
		
		if($idGroupe != 0) {
			$this->db->join('GroupeUtilisateur', 'GroupeUtilisateur.idGroupe = Groupe.id AND GroupeUtilisateur.emailUtilisateur = "' . $this->session->userdata('email') .'"');
		}
		$data = $this->db->get_where('Groupe', $param, 1);
		
		if($data->num_rows() > 0) {
			return $data;
		} else {
			return false;	
		}
	}
	
	/* getGroupe	: recuperer tous les groupe où l'tulisateur est admin
	 * param1		: id de l'utilisateur
	 * return		: ensemble des données du Groupe
	 */
	public function getGroupeAdmin() {
		$param = array(	'emailAdministrateur' => $this->session->userdata('email'));
		
		$data = $this->db->get_where('Groupe', $param);
		
		if($data->num_rows() > 0) {
			return $data;
		} else {
			return false;	
		}
	}
	
	// permet de recuperer des info sans être l'admin d'un groupe
	public function getGroupeVisiteur($idGroupe) {
		$param = array(	'id' => $idGroupe);
		
		if($idGroupe != 0) {
			$this->db->select('id, emailAdministrateur');
		}
		$data = $this->db->get_where('Groupe', $param, 1);
		
		if($data->num_rows() > 0) {
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
		$this->db->order_by('dateInscriptionGroupe', 'asc');
		$data = $this->db->get();

		return $data;
	}

	/*
	 * getNbGroupePourDocument	: Obtenir le nombre de groupe dans lesquels un même document est présent
	 * param1 					: id du document
	 * return					: 
	 */
	public function getGroupePourUnDocument($idDocument) {
		
		$param = array('GD.idDocument' => $idDocument);
		
		$this->db->join('Groupe GR', 'GR.id = GD.idGroupe');
		$this->db->where('GD.idGroupe !=', '0');
		$query = $this->db->get_where('GroupeDocument GD', $param);
		
		return $query->result();
	}
	
	/*
	 * authAccesGroupe	:
	 * param1			:
	 * param2			: 
	 * return			: true/false
	 */
	public function authAccesGroupe($idGroupe, $email) {
	/*
		SELECT distinct GU.emailUtilisateur
		FROM GroupeDocument GD, GroupeUtilisateur GU 
		WHERE GD.idGroupe = GU.idGroupe 
		AND GD.idGroupe = 1
		AND GU.emailUtilisateur = '$email';
	*/
		$param = array( 'idGroupe' => $idGroupe,
				'emailUtilisateur' => $email
		);
		$data = $this->db->get_where('GroupeUtilisateur', $param);
		
		if($data->num_rows() == 1) {
			return true;
		} else {
			return false;	
		}
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

	/*
	 * quitterGroupe	: supprimer un membre d'un groupe
	 * param1			: id du Groupe
	 * param2			: email de l'utilisateur
	 * return			: true/false
	 */
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
	 * ajouter un membres au groupe
	 * param1			: id du Groupe
	 * param2			: liste des emails utilisateur
	 * return			: true/false
	 */
	public function ajouterMembre($idGroupe, $email) {
		
		$data = array(	'idGroupe'				=> $idGroupe,
						'emailUtilisateur'		=> $email,
						'dateInscriptionGroupe'	=> date("d/m/Y"));
		
		$this->db->trans_begin();
		if( $this->db->insert('GroupeUtilisateur', $data) ) {
			// si l'insertion réussie
			$this->db->trans_commit();
		} else {
			// si l'insertion échoue
			$this->db->trans_rollback();
			return false;
		}	
		// retour de la fonction en cas de réussite
		return true;
	}
	
	
	/*
	 * supprimer des membres d'un groupe
	 * param1			: id du Groupe
	 * param2			: liste des emails utilisateur
	 * return			: true/false
	 */
	public function supprimerMembre($idGroupe, $emails) {
		
		if(empty($emails)) 
		{
			return false;
		}
		
		$this->db->where_in('emailUtilisateur', $emails);
		$this->db->where('idGroupe', $idGroupe);
		if($this->db->delete('GroupeUtilisateur'))
			return true;
		else
			return false;
	}

	/*
	 * addGroupe	: créer un groupe en table Groupe
	 * param1		: table où l'on doit insérer les donnees
	 * param2		: ensemble des données à enregistrer
	 * return		: idGroupe / 0
	 */
	public function addGroupe($table, $data) {
	
		$this->db->trans_begin();	
		if( $this->db->insert($table, $data) ) {
			// si l'insertion réussie
			$insert_id = $this->db->insert_id();
			$this->db->trans_commit();
	
		} else {
			// si l'insertion échoue
			$this->db->trans_rollback();
			return 0;
	
		}	
		// retour de la fonction en cas de réussite
		if($insert_id == 0)
			return true;
		else
			return $insert_id;
	}
	
	/*
	 * updateGroupe	:
	 * 
	 */
	public function updateGroupe($id, $data) {
	
		$this->db->trans_begin();	
		
		$this->db->where('id', $id);
		
		if( $this->db->update('Groupe', $data) ) {
			// si l'insertion réussie
			$this->db->trans_commit();
			return true;
		} else {
			// si l'insertion échoue
			$this->db->trans_rollback();
			return 0;	
		}
	}
	
	/*
	 * addDocGroupe	: associer un document à un groupe
	 * param1		: ensemble des données à enregistrer
	 * return		: true / false
	 */
	public function addDocGroupe($data) {
	
		$this->db->trans_begin();	
		if( $this->db->insert('GroupeDocument', $data) ) {
			// si l'insertion réussie
			$this->db->trans_commit();
	
		} else {
			// si l'insertion échoue
			$this->db->trans_rollback();
			return 0;
	
		}	
		// retour de la fonction en cas de réussite
		return 1;
	
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
	 
	 /* getMembre	: compte tous les membres d'un groupe
	 * param1		: id du Groupe
	 * return		: le nombre d'utilisateur
	 */
	public function countMembres($idgroupe) {
		// compte le nombre d'utilisateur
		$this->db->select('count(*) as nbMembre');
		$this->db->from('GroupeUtilisateur');
		$this->db->where('GroupeUtilisateur.idGroupe =', $idgroupe);
		$data = $this->db->get();

		return $data;
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