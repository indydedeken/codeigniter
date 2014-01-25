<?php 

class Model_document extends CI_Model {
	
	/*
	 * Model_document
	 */
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	// ajouter un document
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
	
	/* getAllDocuments	: récupérer tous les documents d'un utilisateur
	 * param1			: email de l'utilisateur
	 * return			: ensemble des données de chaque document
	 */
	public function getAllDocuments($email) {
		$param = array('emailUtilisateur' => $email);
		
		$this->db->select('Document.id, titre, auteur, auteur, contenu, libelle');
		$this->db->join('EtatDocument', 'Document.etat = EtatDocument.id');
		$data = $this->db->get_where('Document', $param);
		
		return $data;
	}
	
	/* getDocument	: récupérer un document
	 * param1		: id du document
	 * param2		: email de l'utilisateur
	 * return		: ensemble des données du document
	 */
	public function getDocument($idDocument, $email) {
		$this->db->select('*');
		$param = array(	'id'	=> $idDocument,
						'email'	=> $email
		);
		$data = $this->db->get_where('Document', $param);
		if($data->num_rows() == 1) {
			return $data;
		} else {
			return false;	
		}
	}
	
	/*
	 * delDocument	: supprimer un document
	 * param1		: id du document
	 * param2		: email de l'utilisateur
	 * return		: true
	 */
	 public function delDocument($idDocument, $email) {
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