<?php 

class Model_annotation extends CI_Model {
	
	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	
	/*
	 * ajouter une annotation
	public function ajout_annotation($data) {
		$this->db->insert('Annotation', $data);
	}
	*/
	
	/*
	 * supprimer une annotation
	 
	public function supprimer_annotation($data) {
		$this->db->delete('Annotation', $data);
	}
	*/
	
	/*
	 * savoir s'il y a des annotations sur un groupe (ses documents)
	 */
	public function existeAnnotationSurGroupe($idGroupe) {
		$param = array('idGroupe' => $idGroupe);
		
		$query = $this->db->get_where('annotation', $param);
		
		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	/*
	 * savoir s'il y a des annotations sur un document
	 */
	public function existeAnnotationSurDocument($idGroupe, $idDocument) {
		$param = array('idGroupe' => $idGroupe,
			       'idDocument' => $idDocument);
		
		$query = $this->db->get_where('annotation', $param);
		
		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	/*
	 * obtenir les annotations sur l'ensemble des groupes accessibles
	 */
	public function getAnnotationTousGroupes() {
		$param = array('GroupeUtilisateur.emailUtilisateur' => $this->session->userdata('email'));
		
		$this->db->distinct();
		$this->db->select('Annotation.id, Annotation.idDocument, Annotation.idGroupe, Annotation.emailUtilisateur, Document.titre, Annotation.idTypeAnnotation, Annotation.dateCreation, Groupe.intitule');
		$this->db->join('Annotation', 'GroupeUtilisateur.idGroupe = Annotation.idGroupe');
		$this->db->join('Groupe', 'Annotation.idGroupe = Groupe.id');
		$this->db->join('Document', 'Annotation.idDocument = Document.id');
		$this->db->order_by('Annotation.dateCreation', 'desc'); 
		$query = $this->db->get_where('GroupeUtilisateur', $param);
		
		return $query->result();
	}
	
	/*
	 * obtenir les annotations d'un groupe
	 */
	public function getAnnotationGroupe($idGroupe) {
		$param = array('idGroupe' => $idGroupe);
		
		$this->db->select('*');
		$this->db->join('Groupe', 'Annotation.idGroupe = Groupe.id');
		$this->db->join('Document', 'Annotation.idDocument = Document.id');
		$query = $this->db->get_where('Annotation', $param);
		
		return $query->result();
	}
	
	/*
	 * obtenir les annotations d'un document
	 */
	public function getAnnotationDocument($idGroupe, $idDocument) {
		$param = array('idGroupe' => $idGroupe,
			       'idDocument' => $idDocument);
		
		$this->db->select('*');
		$this->db->join('Groupe', 'Annotation.idGroupe = Groupe.id');
		$this->db->join('Document', 'Annotation.idDocument = Document.id');
		$query = $this->db->get_where('Annotation', $param);
		
		return $query->result();
	}	
	
	/*
	 * obtenir les annotations d'une personne
	 */
	public function getAnnotationUser($user) {
		$param = array('emailUtilisateur' => $user);
		
		$this->db->select('*');
		$this->db->join('Groupe', 'Annotation.idGroupe = Groupe.id');
		$this->db->join('Document', 'Annotation.idDocument = Document.id');
		$query = $this->db->get_where('Annotation', $param);
		
		return $query->result();
	}
}