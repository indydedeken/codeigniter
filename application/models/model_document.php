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
	 * param1	: table (nom en DB)
	 * param2	: data (tableau de données auteur, titre, contenu... ) 
	 * return 		: id
	 */
	public function addDocument($table, $data) {
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
	
	/* countDocuments	: connaitre le nombre de documents disponibles
	 * param1 			: email de l'utilisateur, peut-être vide
	 * param2			: etat souhaité des documents
	 * return			: nombre de documents qui correspondent
	 */
	public function countDocuments($email, $etat) {
		
		if($email != '')
			$this->db->like('emailUtilisateur', $email);
		
		if($etat == 'tous') {
		} else if($etat == 'Ouvert') {
			$this->db->like('etat', 0);
		} else if($etat == 'Publié') {
			$this->db->like('etat', 1);
		} else if($etat == 'Fermé') {
			$this->db->like('etat', 2);
		}
		
		$data = $this->db->count_all_results('Document');
		
		return $data;	
	}
	
	/* getAllDocumentsGroupes	: récupérer tous les documents d'un groupe
	 * param1					: id du groupe 
	 * param2					: email de l'utilisateur
	 * return					: ensemble des données de chaque document
	 */
	public function getAllDocumentsGroupe($idGroupe, $email) {
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
		$this->db->join('GroupeUtilisateur', 'Groupe.id = GroupeUtilisateur.idGroupe');
		$this->db->where('GroupeUtilisateur.emailUtilisateur', $email);
		$this->db->where('GroupeUtilisateur.idGroupe', $idGroupe);
		$this->db->group_by('GroupeDocument.idDocument');
		$data = $this->db->get();
		
		return $data;
	}
	
	/* A REFAIRE getTopDocuments	: récupérer tous les documents d'un utilisateur
	 * A REFAIRE param1			: email de l'utilisateur
	 * A REFAIRE return			: ensemble des données de chaque document
	 */
	public function getTopDocuments($email, $limite = NULL) {
		if($limite == NULL)
			$limite = 100;
		
		$param = array('GroupeUtilisateur.emailUtilisateur' => $email);
		
		$this->db->select('Document.id, GroupeDocument.idGroupe, Groupe.intitule, Document.titre, Document.auteur, Document.contenuOriginal, EtatDocument.libelle, Document.dateCreation');
		$this->db->join('EtatDocument', 'Document.etat = EtatDocument.id');
		$this->db->join('GroupeDocument', 'GroupeDocument.idDocument = Document.id');
		$this->db->join('GroupeUtilisateur', 'GroupeDocument.idGroupe = GroupeUtilisateur.idGroupe');
		$this->db->join('Groupe', 'Groupe.id = GroupeUtilisateur.idGroupe');
		$data = $this->db->get_where('Document', $param, $limite);
		
		return $data;
	}
	
	/* getDocuments	: récupérer tous les documents d'un utilisateur
	 * return		: ensemble des données de chaque document
	 */
	public function getDocuments() {
		// récupère toutes les variables du document
		$this->db->select('*');
		$this->db->from('Document');
		$this->db->group_by('id');
		$data = $this->db->get();

		return $data;
	}
	
	/* getAllDocuments	: récupérer tous les documents d'un utilisateur
	 * param1			: email de l'utilisateur
	 * return			: ensemble des données de chaque document
	 */
	public function getAllDocuments($email, $limite = NULL) {
		if($limite == NULL)
			$limite = 100;
		
		$param = array('GroupeUtilisateur.emailUtilisateur' => $email);
		
		$this->db->select('Document.id, GroupeDocument.idGroupe, Groupe.intitule, Document.titre, Document.auteur, Document.contenuOriginal, EtatDocument.libelle, Document.dateCreation');
		$this->db->join('EtatDocument', 'Document.etat = EtatDocument.id');
		$this->db->join('GroupeDocument', 'GroupeDocument.idDocument = Document.id');
		$this->db->join('GroupeUtilisateur', 'GroupeDocument.idGroupe = GroupeUtilisateur.idGroupe');
		$this->db->join('Groupe', 'Groupe.id = GroupeUtilisateur.idGroupe');
		$data = $this->db->get_where('Document', $param, $limite);
		
		return $data;
	}
	
	
	
	/* getAllDocuments	: récupérer tous les documents d'un utilisateur
	 * param1			: email de l'utilisateur
	 * return			: ensemble des données de chaque document
	 */
	public function getBibliotheque($email) {
		
		$param = array('Document.emailUtilisateur' => $email);
		
		$this->db->select('Document.id, Document.titre, Document.auteur, Document.contenuOriginal, Document.dateCreation');
		$data = $this->db->get_where('Document', $param);
		
		return $data;
	}
	
	/* getDocument	: récupérer un document
	 * param1	: id du document
	 * param2	: email de l'utilisateur
	 * return	: ensemble des données du document
	 */
	public function getDocument($idDocument, $email, $idGroupe) {
		
		
		
		if($idGroupe == 0) {
			$param	= array('Document.id' => $idDocument,
					'Document.emailUtilisateur' => $email
			);
			
			$this->db->select('*');
			$data = $this->db->get_where('Document', $param);
			
		} else {
			$param	= array( 'GroupeDocument.idDocument' => $idDocument);
		
			$this->db->select('*');
			$this->db->join('GroupeUtilisateur', 'GroupeUtilisateur.idGroupe = GroupeDocument.idGroupe');
			$this->db->join('Document', 'GroupeDocument.idDocument = Document.id');
			$this->db->where('GroupeUtilisateur.emailUtilisateur', $email);
			$this->db->where('GroupeUtilisateur.idGroupe', $idGroupe);
			$data = $this->db->get_where('GroupeDocument', $param);
		}
		
		if($data->num_rows()>0) {
			return $data;
		} else {
			return false;	
		}
	}
	
	/* delDocument	: supprimer un document
	 * param1		: id du document
	 * param2		: email de l'utilisateur
	 * return		: true
	 */
	 public function delDocument($idDocument, $email) {
		
		/* PRÉVOIR SI LE MEMBRE EST ADMIN, ALORS 		*/
		/* ON FAIT LE NÉCESSAIRE DANS TOUTES LES TABLES */
		$param = array(	'id'	=> $idDocument,
						'email'	=> $email 
		);
	 	if($this->db->delete('Document', $param))
			return true;
		else
			return false;		 	
	 }
	 
	 /*
	 * delDocumentAnnexe	: supprimer un document dans les autres tables que Document
	 * param1				: id du document
	 * return				: true
	 */
	 /* BUG SI DECOMMENTER, A CORRIGER + tard
	 public function delDocument($idDocument) {
		$table = array('GroupeDocument', 'Annotation');
		$param = array(	'idDocument' => $idDocument);
	 	if($this->db->delete($table, $param))
			return true;
		else
			return false;		 	
	 }
	 */
}