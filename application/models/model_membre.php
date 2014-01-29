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
		$this->db->insert('Utilisateur', $data);
	}
	
	/* verifier qu'un membre est présent en DB */
	public function check_membre($email, $mdp = NULL) {
		$this->db->where('email', $email);
		$this->db->where('mdp', $mdp);
		$data = $this->db->get('Utilisateur');
		if($data->num_rows() == 1) {
			return true;
		}
		return false;
	}

	/* recuperer les infos d'un membre */
	public function get_membre($email) {
		$this->db->select('*');
		$this->db->where('email', $email);
		$data = $this->db->get('Utilisateur');
		if($data->num_rows() == 1) {
			return $data;
		} else {
			return false;	
		}
	}
	
	/* MAJ des infos simple : NOM, PRENOM, ETATCIVIL, MAILPRO */
	public function maj_info_unite($email, $data) {
		$this->db->where('email', $email);
		$this->db->update('Utilisateur', $data);
	}
	
	/* MODELE MAJ du mdp */
	public function maj_mdp($mdp, $newMdp) {
		$this->db->where('mailPerso', $this->session->userdata('login'));
		$this->db->update('membre', array('mdp' => sha1($newMdp)));
	}
	
	/* MODELE MAJ des emails */
	public function maj_mail($login, $newMailPerso) {
		$this->db->where('mailPerso', $login);
		$this->db->update('membre', array('mailPerso' => $newMailPerso));
	}
	
	/* MODELE ajouter/modifier un cursus */
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
	
	/* MODELE ajouter/modifier un parcours */
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
}