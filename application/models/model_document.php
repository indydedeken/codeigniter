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
	 * param1		: data (tableau de données auteur, titre, contenu... ) 
	 * return 		: true
	 */
	public function addDocument($data) {
			$this->db->insert('Document', $data);
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
		$this->db->join('EtatDocument', 'Document.id = EtatDocument.id');
		$this->db->join('GroupeDocument', 'Document.id = GroupeDocument.idDocument');
		$this->db->join('Groupe', 'GroupeDocument.idGroupe = Groupe.id');
		$this->db->join('GroupeUtilisateur', 'Groupe.id = GroupeUtilisateur.idGroupe');
		$this->db->where('GroupeUtilisateur.emailUtilisateur', $email);
		$this->db->where('GroupeUtilisateur.idGroupe', $idGroupe);
		$this->db->group_by('GroupeDocument.idDocument');
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
		
		$param = array('Document.emailUtilisateur' => $email);
		
		$this->db->select('Document.id, Document.titre, Document.auteur, Document.auteur, Document.contenu, EtatDocument.libelle');
		$this->db->join('EtatDocument', 'Document.etat = EtatDocument.id');		
		$data = $this->db->get_where('Document', $param, $limite);
		
		return $data;
	}
	
	/* getDocument	: récupérer un document
	 * param1		: id du document
	 * param2		: email de l'utilisateur
	 * return		: ensemble des données du document
	 */
	public function getDocument($idDocument, $email) {
		/*
		 * vérifier que l'utilisateur à acces à un groupe,
		 * et que ce groupe comprend l'email de l'utilisateur
		 */
		
		$param = array(	'id'	=> $idDocument,
						'emailUtilisateur'	=> $email
		);
		$data = $this->db->get_where('Document', $param);
		if($data->num_rows() == 1) {
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