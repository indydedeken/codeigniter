<?php 

class Model_document extends CI_Model {
	
	/*
	 * Model_document
	 * Utilisation de tout ce qui concerne les documents
	 */
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	/* addDocument	: ajouter un document
	 * param1		: table (nom en DB)
	 * param2		: data (tableau de données auteur, titre, contenu... ) 
	 * return 		: id / false
	 */
	public function addDocument($table, $data) {
		$this->db->trans_begin();
		if( $this->db->insert($table, $data) ) {
			$insert_id = $this->db->insert_id();
			$this->db->trans_commit();
		} else {
			$this->db->trans_rollback();
			return false;
		}
		return $insert_id;
	}
	
	/* delDocument	: supprimer un document
	 * param1		: id du document
	 * return		: true
	 */
	 public function delDocument($idDocument) {
		
		$where = array(	'Document.emailUtilisateur' => $this->session->userdata('email'),
						'Document.id' => $idDocument);
		
		/* PRÉVOIR SI LE MEMBRE EST ADMIN, ALORS 	*/
		/* ON FAIT LE NÉCESSAIRE DANS TOUTES LES TABLES */
		$this->db->trans_begin();
		
		$this->db->select('*');
		$this->db->where($where);
		$data = $this->db->get('Document');
		
		if($data->num_rows() == 0)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		
		// TABLE markus.document
		$this->db->where('id', $idDocument);
		$this->db->where('emailUtilisateur', $this->session->userdata('email'));
		$this->db->delete('Document');
		
		// TABLE markus.GroupeDocument
		$this->db->where('idDocument', $idDocument);
		$this->db->delete('GroupeDocument');
		
	 	if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
	 	}
		else {
			// effecer le fichier
			//unlink('./files/' . $file->filename);
			$this->db->trans_commit();
			return TRUE;
		}
	 }
	
	/* countDocumentsFromGroup	: récupérer le nombre de document d'un groupe
	 * param1					: id du groupe 
	 * return					: nombre de document dans un groupe donne
	 */
	public function countDocumentsFromGroup($idGroupe) {
		$this->db->like('idGroupe', $idGroupe);
		$this->db->from('GroupeDocument');
		
		return $this->db->count_all_results();
	}
	
	/* getAllDocumentsFromGroup	: récupérer tous les documents d'un groupe
	 * param1					: id du groupe 
	 * param2					: nombre de résultat a afficher
	 * param3					: document a exclure des resultats
	 * return					: data des documents du groupe
	 */
	public function getAllDocumentsFromGroup($idGroupe, $limite = null, $documentExclu = null) {
		
		$where = array(	'GroupeUtilisateur.emailUtilisateur' => $this->session->userdata('email'),
						'GroupeUtilisateur.idGroupe' => $idGroupe);
		
		if($limite == NULL)
			$limite = 100; // si aucune limite, on la fixe a 100
			
		$this->db->select('	Document.id as idDocument, 
							Document.emailUtilisateur, 
							Document.auteur, 
							Document.titre, 
							Document.description,
							Document.dateCreation, 
							Document.etat, 
							Document.contenuOriginal,
							EtatDocument.libelle,
							GroupeDocument.idGroupe as idGroupe');
		$this->db->from('Document');
		$this->db->join('EtatDocument', 'Document.etat = EtatDocument.id');
		$this->db->join('GroupeDocument', 'Document.id = GroupeDocument.idDocument');
		$this->db->join('Groupe', 'GroupeDocument.idGroupe = Groupe.id');
		$this->db->join('GroupeUtilisateur', 'Groupe.id = GroupeUtilisateur.idGroupe');
		$this->db->where($where);
		
		// si on precise un document, celui-ci est exclu
		if($documentExclu != NULL) {
			$this->db->where_not_in('GroupeDocument.idDocument', $documentExclu);
		}
		$this->db->group_by('GroupeDocument.idDocument');
		$this->db->limit($limite);
		$data = $this->db->get();
		
		return $data;
	}
	
	/* getPersonalLibrary		: récupérer tous les documents uploadé (personnel)
	 * param1					: document Exclu du résultat
	 * return					: ensemble des données de chaque document
	 */
	public function getPersonalLibrary($documentExclu = NULL) {
		
		$where = array(	'Document.emailUtilisateur' => $this->session->userdata('email'),
						'Groupe.id' => '0'); // 0 correspond aux bibliotheques personnelles
		
		$this->db->select('	Document.id as idDocument, 
							Document.emailUtilisateur, 
							Document.auteur, 
							Document.titre, 
							Document.description,
							Document.dateCreation, 
							Document.etat, 
							EtatDocument.libelle');
		$this->db->from('Document');
		$this->db->join('EtatDocument', 'Document.etat = EtatDocument.id');
		$this->db->join('GroupeDocument', 'Document.id = GroupeDocument.idDocument');
		$this->db->join('Groupe', 'GroupeDocument.idGroupe = Groupe.id');
		if($documentExclu != NULL) {
			$this->db->where_not_in('GroupeDocument.idDocument', $documentExclu);
		}
		$this->db->where($where);		
		$this->db->group_by('GroupeDocument.idDocument');
		
		return $this->db->get();
	
	}
	
	/* A REFAIRE getTopDocuments: récupérer les meilleurs documents d'un utilisateur
	 * A REFAIRE param1			: nombre max de doc a afficher
	 * A REFAIRE return			: ensemble des données de chaque document
	 */
	public function getTopDocuments($limite = NULL) {
		if($limite == NULL)
			$limite = 100;
		
		$where = array('GroupeUtilisateur.emailUtilisateur' => $this->session->userdata('email'));
		
		$this->db->select('	Document.id, 
							GroupeDocument.idGroupe, 
							Groupe.intitule, 
							Document.titre, 
							Document.auteur, 
							Document.contenuOriginal, 
							EtatDocument.libelle, 
							Document.dateCreation');
		$this->db->join('EtatDocument', 'Document.etat = EtatDocument.id');
		$this->db->join('GroupeDocument', 'GroupeDocument.idDocument = Document.id');
		$this->db->join('GroupeUtilisateur', 'GroupeDocument.idGroupe = GroupeUtilisateur.idGroupe');
		$this->db->join('Groupe', 'Groupe.id = GroupeUtilisateur.idGroupe'); 
		
		return $this->db->get_where('Document', $where, $limite);
	}
	
	/* getDocumentsToSearch	: recuperation de tous les documents (search header)
	 * return				: ensemble des données de chaque document
	 */
	public function getDocumentsToSearch() {
		// récupère toutes les variables du document
		$this->db->select('*');
		$this->db->from('Document');
		$this->db->group_by('id');
		return $this->db->get();
	}
	
	/* getAllDocuments	: récupérer tous les documents d'un utilisateur, dans tous ses groupes
	 * return			: ensemble des données de chaque document
	 */
	public function getAllDocuments($limite = NULL) {
		$where = array('GroupeUtilisateur.emailUtilisateur' => $this->session->userdata('email'));
		
		if($limite == NULL)
			$limite = 100;
		
		$this->db->select('Document.id, GroupeDocument.idGroupe, Groupe.intitule, Document.titre, Document.auteur, Document.contenuOriginal, EtatDocument.libelle, Document.dateCreation');
		$this->db->join('EtatDocument', 'Document.etat = EtatDocument.id');
		$this->db->join('GroupeDocument', 'GroupeDocument.idDocument = Document.id');
		$this->db->join('GroupeUtilisateur', 'GroupeDocument.idGroupe = GroupeUtilisateur.idGroupe');
		$this->db->join('Groupe', 'Groupe.id = GroupeUtilisateur.idGroupe');
		
		return $this->db->get_where('Document', $where, $limite);
	}
	
	/* getDocument	: récupérer un document dans un groupe
	 * param1		: id du document
	 * param2		: email de l'utilisateur
	 * return		: ensemble des données du document
	 */
	public function getDocument($idDocument, $idGroupe) {
		
		if($idGroupe == 0) {
			$param	= array('Document.id' => $idDocument,
							'Document.emailUtilisateur' => $this->session->userdata('email')
			);
			
			$this->db->select('*');
			$data = $this->db->get_where('Document', $param);
		} 
		else
		{
			$param	= array( 'GroupeDocument.idDocument' => $idDocument);
			
			$this->db->select('*');
			$this->db->join('GroupeUtilisateur', 'GroupeUtilisateur.idGroupe = GroupeDocument.idGroupe');
			$this->db->join('Document', 'GroupeDocument.idDocument = Document.id');
			$this->db->where('GroupeUtilisateur.emailUtilisateur', $this->session->userdata('email'));
			$this->db->where('GroupeUtilisateur.idGroupe', $idGroupe);
			$data = $this->db->get_where('GroupeDocument', $param);
		}
		
		if($data->num_rows()>0) {
			return $data;
		} else {
			return false;	
		}
	}
	
	// METTRE EN PLACE TRASACTION !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	/* change_etat_document	: faire évoluer l'état d'un document
	 * param1				: id du document
	 * param2				: etat actuel du document
	 * return				: true / false
	 */
	public function change_etat_document($idDoc, $etat) {
		//UPDATE Document SET etat=etat+1 WHERE id=3 AND email=$email;
		if($etat < 2)
			$etat += 1;
		else
			return 2;
		
		$data	= array('etat' 				=> $etat);
		$where	= array('id' 				=> $idDoc,
						'emailUtilisateur'	=> $this->session->userdata('email')); 
						
		return $this->db->update('Document', $data, $where);
	}
	 
	 /*
	 * estAdministrateur	: savoir si un membre est admin du document
	 * param1				: id du document
	 * param2				: email de l'utilisateur
	 * return				: true/false
	 */
	public function estAdministrateur($idDoc, $email) {
		$param = array(	'id' 				=> $idDoc,
						'emailUtilisateur'	=> $email
		);

		$data = $this->db->get_where('Document', $param);

		if($data->num_rows() == 1) {
			return true;
		} else {
			return false;	
		}
	}
}