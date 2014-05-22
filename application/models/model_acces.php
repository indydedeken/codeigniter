<?php 

class Model_acces extends CI_Model {
	
	/*
	 * Model_acces
	 * Utilisation de tout ce qui concerne les acces aux groupes
	 */
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

	/*
	 * retourne les groupes : 
	 * + où l'utilisateur est admin
	 * + il y a une/des demande(s) 
	 
	public function getGroupeAValider($table) {
		$data = array();
		
		//emailAdministrateur == $this->session->userdata('email');
		
		// retourne 
		// + id
		// + nom du groupe
		return $data;
	}*/
	
	/*
	 * retourne les demandes de membre pour un groupe 
	 */
	public function getMembresAValider($email) {
		$data = array();
		
		$param	= array('GestionAcces.emailAdministrateur' => $email, 
						'GestionAcces.avis' => '0');
		
		$this->db->select('*', false);
		$this->db->join('Groupe', 'Groupe.id = GestionAcces.idGroupe');
		$data = $this->db->get_where('GestionAcces', $param);
		
		return $data->result();
	}
	
	/*
	 * retourne les groupes où l'acces du membre n'est pas refusé, ni accepté
	 */
	public function getGroupeWait($email) {		
		$data	= array();
		$param	= array(	'emailUtilisateur' => $email, 
							'avis' => '0');
		
		$this->db->select('GestionAcces.idGroupe, Groupe.intitule', false);
		$this->db->join('Groupe', 'Groupe.id = GestionAcces.idGroupe');
		$data = $this->db->get_where('GestionAcces', $param);

		return $data->result();
	}
	
	/*
	 * retourne les groupes où l'acces du membre a été validé
	 */
	public function getGroupeOK($email) {
		$data	= array();
		$param	= array(	'emailUtilisateur' => $email, 
							'avis' => '1');
		
		$this->db->select('GestionAcces.idGroupe, Groupe.intitule', false);
		$this->db->join('Groupe', 'Groupe.id = GestionAcces.idGroupe');
		$data = $this->db->get_where('GestionAcces', $param);
		
		return $data->result();
	}
	
	/*
	 * retourne les groupes où l'acces du membre a été refusé
	 */
	public function getGroupeKO($email) {
		$data	= array();
		$param	= array(	'emailUtilisateur' => $email, 
							'avis' => '2');
		
		$this->db->select('GestionAcces.idGroupe, Groupe.intitule', false);
		$this->db->join('Groupe', 'Groupe.id = GestionAcces.idGroupe');
		$data = $this->db->get_where('GestionAcces', $param);
		
		return $data->result();
	}
	
	
	public function nouvelleDemandeAccesGroupe($idGroupe, $emailAdministrateur, $emailUtilisateur) {
		// l'état de la demande est à 0
		$table = 'GestionAcces';
		$data = array(	'idGroupe'				=> $idGroupe, 
						'emailAdministrateur'	=> $emailAdministrateur,
						'emailUtilisateur'		=> $emailUtilisateur,
						'dateDemande'			=> date("d/m/Y"),
						'avis'					=> 0);
		
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
		return $insert_id;
	}
	
	
	public function validationAccesGroupe($idGroupe, $emailAdministrateur, $emailUtilisateur, $avis) {
		// l'état de la demande est à 
		// avis=1 : accepté
		// avis=2 : refusé
		
		$data = array(
               'avis'			=> $avis,
               'dateValidation' => date('d/m/Y')
        );
		$where = array(	'idGroupe'				=> $idGroupe, 
						'emailAdministrateur'	=> $emailAdministrateur,
						'emailUtilisateur'		=> $emailUtilisateur
		);
		
		$this->db->trans_begin();	
		if( $this->db->update('GestionAcces', $data, $where) ) {
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
	
	/****************************************************/
	/* acces/suppressionDemandeAcces					*/
	/*													*/
	/* BUT : supprimer une ligne d'accès (GestionAcces)	*/
	/****************************************************/
	public function suppressionDemandeAcces($idGroupe, $emails) {
		
		$this->db->where_in('emailUtilisateur', $emails);
		$this->db->where('idGroupe', $idGroupe);
		
		$this->db->trans_begin();	
		if( $this->db->delete('GestionAcces') ) 
		{
			// si l'insertion réussie
			$this->db->trans_commit();
			
		} else 
		{
			// si l'insertion échoue
			$this->db->trans_rollback();
			return false;
		}
		
		return true;
	}
}