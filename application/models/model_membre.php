<?php 

class Model_membre extends CI_Model {
	
	/**
	 *
	 * Le code qui suit, est un exemple de model
	 * utilisé pour la gestion des membres sur une autre application.
	 * Faire le nouveau code au dessus de ce paragraphe 
	 * ou bien dans un autre fichier.
	 *
	 */
	
	function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
	
	/* inscription d'un membre */
	public function ajout_membre($data) {
		$this->db->insert('membre', $data);
	}
	
	/* verification pour la connexion */
	public function check_membre($login, $mdp) {
		$this->db->where('login', $login);
		$this->db->where('mdp', $mdp);
		$data = $this->db->get('membre');
		if($data->num_rows() == 1) {
			return true;
		}
	}

	/* recuperer les infos d'un membre */
	public function get_membre($mail) {
		$this->db->select('*');
		$this->db->where('email', $mail);
		$data = $this->db->get('membre');
		if($data->num_rows() == 1) {
			return $data;
		} else {
			return false;	
		}
	}
	
	/* MAJ des infos simple : NOM, PRENOM, ETATCIVIL, MAILPRO */
	public function maj_info_simple($data) {
		
		$this->db->where('mailPerso', $this->session->userdata('login'));
		$this->db->update('membre', $data);
	}
	
	/* MAJ du mdp */
	public function maj_mdp($mdp, $newMdp) {
		$this->db->where('mailPerso', $this->session->userdata('login'));
		$this->db->update('membre', array('mdp' => sha1($newMdp)));
	}
	
	/* MAJ des emails */
	public function maj_mail($login, $newMailPerso) {
		$this->db->where('mailPerso', $login);
		$this->db->update('membre', array('mailPerso' => $newMailPerso));
	}
	
	/* recuperer le cursus SCOLAIRE d'un membre */
	public function get_cursus($id){
		$data = $this->db->query('	SELECT annee, nomEtab, nomDiplome, cursus.idDiplome, cursus.idEtab, cursus.idMembre
									FROM cursus, membre, etablissement, diplome 
									WHERE cursus.idEtab = etablissement.idEtab 
									AND cursus.idMembre = membre.id
									AND cursus.idDiplome = diplome.idDiplome
									AND id = '.$id.'
									ORDER BY annee DESC;
									');
		return $data;
	}
	
	
	
	/* ajouter/modifier un cursus */
	function gestion_cursus($action, $idMembre, $idEtab, $idDiplome, $annee) {
		if($action == "enregistrer") {
			
			$data = array(	'idMembre'=>$idMembre,
							'idEtab'=>$idEtab,
							'idDiplome'=>$idDiplome,
							'annee'=>$annee
							);
							
			$req = $this->db->get_where('cursus', $data);
			
			if($req->num_rows() == 1) {
				return false;	
			} else {
				$this->db->insert('cursus', $data);				
			}
			
			return true;
		}else if($action == "supprimer") {
			$this->db->delete('cursus', array(	'idMembre' 	=> $idMembre,
												'idEtab' 	=> $idEtab,
												'idDiplome'	=> $idDiplome,												
												));	
		}
	}
	
	/*
	function test() {
		$this->db->delete('cursus', array('idDiplome' => '6'));	
	}*/
	
	/* vérifie l'existence d'un etablissement */
	function check_etab($nomEtab) {
		
		$data = $this->db->query(' SELECT idEtab FROM etablissement WHERE nomEtab = "'.$nomEtab.'";');
		foreach($data->result() as $item){
			$idEtab = $item->idEtab;
		}

		if(isset($idEtab)) {
			return $idEtab;
		} else {
			return FALSE; 	
		}
	}
	
	/* vérifie l'existence d'un diplome */
	function check_diplome($nomDiplome) {
		
		$data = $this->db->query(' SELECT idDiplome FROM diplome WHERE nomDiplome = "'.$nomDiplome.'";');
		foreach($data->result() as $item){
			$idDiplome = $item->idDiplome;
		}

		if(isset($idDiplome)) {
			return $idDiplome;
		} else {
			return FALSE; 	
		}
	}
	
	/* ajouter un etablissement */
	function ajouter_etab($data) {
		$this->db->insert('etablissement', $data);		
	}
	
	/* ajouter un diplome */
	function ajouter_diplome($data) {
		$this->db->insert('diplome', $data);		
	}
	
	/* recuperer le parcours PRO d'un membre */
	public function get_parcours($id){
		$data = $this->db->query('	SELECT nomSociete, parcours.debut, parcours.fin, parcours.idMembre, parcours.idSociete 
									FROM parcours, membre, societe 
									WHERE membre.id = parcours.idMembre 
									AND parcours.idSociete = societe.idSociete
									AND parcours.idMembre = '.$id.'
									ORDER BY debut DESC, fin;
									');
		return $data;
	}
	
	
	/* ajouter/modifier un parcours */
	function gestion_parcours($action, $idMembre, $idSociete, $debut, $fin) {
		if($action == "enregistrer") {			
			$data = array(	'idMembre'	=> $idMembre,
							'idSociete'	=> $idSociete,
							'debut'		=> $debut,
							'fin'		=> $fin
							);
			$req = $this->db->get_where('parcours', $data);
			
			if($req->num_rows() == 1) {
				return false;	
			} else {
				$this->db->insert('parcours', $data);
			}
		} else if($action == "supprimer") {
			$this->db->delete('parcours', array('idMembre' 	=> $idMembre,
												'idSociete' => $idSociete,
												'debut' 	=> $debut,
												'fin'		=> $fin
												));
			return true;
		}
	}
	
	/* vérifie l'existence d'une societe */
	function check_societe($nomSociete) {
		
		$data = $this->db->query(' SELECT idSociete FROM societe WHERE nomSociete = "'.$nomSociete.'";');
		foreach($data->result() as $item){
			$idSociete = $item->idSociete;
		}

		if(isset($idSociete)) {
			return $idSociete;
		} else {
			return FALSE; 	
		}
	}
	
	/* ajouter une societe */
	function ajouter_societe($data) {
			$this->db->insert('societe', $data);
	}
}