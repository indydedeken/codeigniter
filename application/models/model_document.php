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
	 public function delDocument($idDocument) {
		$table = array('GroupeDocument', 'Annotation');
		$param = array(	'idDocument' => $idDocument);
	 	if($this->db->delete($table, $param))
			return true;
		else
			return false;		 	
	 }
	 
	 
	 
}