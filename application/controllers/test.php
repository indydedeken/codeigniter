<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	/*
		is_string
		is_bool
		is_true
		is_false
		is_int
		is_numeric
		is_float
		is_double
		is_array
		is_null
	*/

	public function index() {
		echo 'Test de l\'application :<br><br>';
		
		$page[] = 'document';
		
		foreach($page as $item)
			echo anchor(base_url("test/".$item),base_url("test/".$item)).'<br>';
		
	}
	
	/* 
	 * Test du model : Document
	 * 
	 */
	public function document() {
		
		// BEGIN - countDocument : compter le nombre de document d'un utilisateur
		$data = array('etat' => '0');
		$test = $this->model_document->countDocumentsFromGroup(0);
		$expected_result = 'is_int';
		$test_name = 'Compter les documents a l\'etat : ' . $data['etat'];
		$this->unit->run($test, $expected_result, $test_name, '');
		
		$data = array('etat' => '1');
		$test = $this->model_document->countDocuments('indy@indy.fr', 1);
		$expected_result = 'is_int';
		$test_name = 'Compter les documents a l\'etat : ' . $data['etat'];
		$this->unit->run($test, $expected_result, $test_name, '');
		
		$data = array('etat' => '2');
		$test = $this->model_document->countDocuments('indy@indy.fr', 2);
		$expected_result = 'is_int';
		$test_name = 'Compter les documents a l\'etat : ' . $data['etat'];
		$this->unit->run($test, $expected_result, $test_name, '');
		// END - countDocument
		
		// BEGIN - getAllDocumentsGroupe : récupération de tous les document d'un groupe pour un utilisateur
		$data = array('idGroupe' => 1, 'email' => 'indy@indy.fr');
		$test = $this->model_document->getAllDocumentsGroupe($data['idGroupe'], $data['email'])->result();
		$expected_result = 'is_array';
		$test_name = 'Recuperer tous les documents d\'un utilistateur';
		$this->unit->run($test, $expected_result, $test_name, 'Fonction getAllDocumentsGroupe()');
		
		foreach($test as $item) {
		/* 	Vérifier que tous les champs sont existants
			Document.idDocument, 
			Document.emailUtilisateur, 
			Document.auteur, 
			Document.titre, 
			Document.description,
			Document.dateCreation, 
			Document.etat, 
			EtatDocument.libelle
		*/
			$testChamp[] = $item->idDocument;
			$testChamp[] = $item->emailUtilisateur;
			$testChamp[] = $item->auteur;
			$testChamp[] = $item->titre;
			$testChamp[] = $item->description;
			$testChamp[] = $item->dateCreation;
			$testChamp[] = $item->etat;
			$testChamp[] = $item->libelle;
			
			foreach($testChamp as $intitule) {
				$testVar = $intitule;
				$expected_result = 'is_string';
				$test_name = 'Test variable de getAllDocumentsGroupe()';
				$variable = (strlen($intitule)>50) ? substr($intitule, 0, 50)."...": $intitule;
				$this->unit->run($testVar, $expected_result, $test_name, 'variable :  ' . $variable);		
			}
		}
		// END - getAllDocumentsGroupe
		
		echo 'Test du modele DOCUMENT';
		echo ' (' . anchor(base_url('test'), 'Retour').')';
		echo $this->unit->report();
	}

}