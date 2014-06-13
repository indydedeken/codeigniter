<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Document extends CI_Controller {

	public function index() {
		// vérifier que l'utilisateur est connecté
		if(	$this->session->userdata('logged') && $this->session->userdata('email')) 
		{
			redirect(site_url().'document/gestion');
		} 
		else 
		{
			redirect('membre/register');
		}
	}

	/************************************************/
	/* document/gestion				*/
	/*						*/
	/* BUT : gestion des document d'un utilisateur	*/
	/************************************************/
	public function gestion() {
		
		$data['nav'] = "gestionDoc"; 
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$email = $this->session->userdata('email');
			
			$data['groupes']		= $this->model_groupe->getAllGroupes($email);
			$data['documents']		= $this->model_document->getAllDocuments($email);
			$data['documentsPersonnels']	= $this->model_document->getDocumentsPerso($email);
			//$data['nbGroupeUtilisateur']	= $this->model_groupe->countGroupes($email);
			
			$this->load->view('header', $data);
			$this->load->view('document/vue_gestion_document', $data);
			$this->load->view('footer', $data);
		
		} else {
			// si non loggé && sans email
			redirect(site_url().'home');	
		
		}
	}
	
	/********************************************************/
	/* document/afficher/<idDocument>/groupe/<idGroupe>	*/
	/*							*/
	/* BUT : afficher un document				*/
	/********************************************************/
	public function afficher() {
		// Multiples possibilité pour arriver sur cette page :
		// URI KO --> afficher l'ensemble des documents
		// URI KO --> 
		// URI OK --> pas dans le groupe :
		//
		//
		
		$data['nav'] = "afficher"; 
		
		// vérifier l'accès à la page
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$idDocument = $this->uri->segment(3);
			$idGroupe = $this->uri->segment(5);
			$email = $this->session->userdata('email');
			
			if($idGroupe == NULL) 
			{
				// fonction qui calcule le nombre de document correspondant
				// == 1 document 
				// -------> redirection ici avec la variable idGroupe dans l'URL
				// == +1 document
				// -------> lister les groupes avec une demande d'accès
				
				$grpPourDocument = $this->model_groupe->getGroupePourUnDocument($idDocument);
				
				$nbGroupe = count($grpPourDocument);
				
				if($nbGroupe == 1 || $grpPourDocument == NULL) 
				{
					// redirection vers l'unique document existant
					if ($grpPourDocument == NULL)
						$idGroupe = 0;
					else
						$idGroupe = $grpPourDocument[0]->idGroupe;
					redirect(site_url().'document/afficher/' . $idDocument . '/groupe/' . $idGroupe);	
				} 
				else if ($nbGroupe > 1)
				{
					// si pas d'idGroupe --> lister les groupes
					$data['idDocument']	= $idDocument;
					$data['nbGroupe']	= $nbGroupe;
					$data['listeGroupe']	= $grpPourDocument;
					
					$this->load->view('header', $data);
					$this->load->view('document/vue_afficher_document_liste_groupe', $data);
					$this->load->view('footer', $data);
				}
				else {
					$this->load->view('header', $data);
					echo "OLA";	
					$this->load->view('footer', $data);
				}
			} 
			else 
			{
				// si idGroupe + accès OK --> affiche le document
				if($this->model_document->getDocument($idDocument, $this->session->userdata('email'), $idGroupe)) 
				{
					$limite = 5;
					$data['idGroupe']	 	= $idGroupe;
					$data['documents']	= $this->model_document->getDocument($idDocument, $email, $idGroupe);
					if($idGroupe == 0){
						$data['listeDocumentsPerso']	= $this->model_document->getDocumentsPerso($email, $limite, $idDocument);
					}
					else
					{
						$data['listeDocumentsGroupe']	= $this->model_document->getAllDocumentsGroupe($idGroupe, $email, 6, $idDocument);
					}
					//getDocument($idDocument, $email, $idGroupe);
					//$data['document'] 		= $this->model_document->getDocument($id, $this->session->userdata('email'));
					//$data['estAdministrateur'] 	= $this->model_document->estAdministrateur($id, $this->session->userdata('email'));
					$data['idDocument']		= $idDocument;
	
					$this->load->view('header', $data);
					$this->load->view('document/vue_afficher_document', $data);
					$this->load->view('footer', $data);
			
				} 
				else 
				{
					// si id Groupe + accès KO --> proposer de demander l'accès
					$this->load->view('header', $data);
					echo "Le document n'est surement pas présent dans la table GroupeDocument...";
					//$this->load->view('document/vue_afficher_document_inaccessible', $data);
					$this->load->view('footer', $data);
				}	
			}
		} else {
			redirect(site_url().'membre');	
		}
	}
	
	/****************************************/
	/* document/creer/						*/
	/*										*/
	/* BUT : formulaire d'upload de document*/
	/* 		 								*/
	/****************************************/
	public function creer() {
		
		//$data['nav'] = "creer"; 
		
		// vérifier que l'utilisateur à le droit d'accès
		if($this->session->userdata('email') && $this->session->userdata('logged')) {
			
			$data = "";
			
			$this->load->view('header', $data);
			$this->load->view('document/vue_creer_document', $data);
			$this->load->view('footer', $data);
			
		} else {
			redirect(site_url().'membre');
		}
	}
	
	/****************************************/
	/* document/upload/						*/
	/*										*/
	/* BUT : upload de document				*/
	/* 		 								*/
	/****************************************/
	public function upload() {
		if($this->session->userdata('email') && $this->session->userdata('logged'))  {
			
			$status	= ""; // indique le status de la requete (success, error)
			$msg	= ""; // message retourné sur la page d'upload
			$file_element_name = 'userfile';
			$directory	= "./filesUploaded/user_" . md5($this->session->userdata('email')) . "/";
			
			if(!file_exists($directory))
			{
				// création du dossier de l'utilisateur
				mkdir($directory);
			}
			
			// paramétrage des règles d'upload
			$config['upload_path'] 		= $directory;
			$config['allowed_types'] 	= 'pdf';
			$config['max_size'] 		= 1024*15;
			$config['max_filename']		= '255';
			$config['remove_spaces'] 	= 'TRUE';
			$config['overwrite']		= 'TRUE';
			
			$this->load->library('upload', $config);
			
			$data = array(); 
			
			if ( !$this->upload->do_upload() )
			{
				// consulter les erreurs
				//echo $this->upload->display_errors();
				
				$status = 'error';
				$msg = ':( Seuls les documents PDF sont autorisés ici. Réessaye !';
				//si l'upload échoue on redirige vers la page d'upload de document
				//redirect(site_url().'document/creer');
			}
			else
			{		
				$data = array('upload_data' => $this->upload->data());
				// ['raw_name']	 = nom_du_fichier
				// ['orig_name'] = nom_du_fichier.pdf
				
				if( $data['upload_data']['raw_name'] != '' ) {
						
					$titreFichier = str_ireplace("_", " ", $data['upload_data']['raw_name']);
					
					if ($this->input->post('titre'))
						$titre = $this->input->post('titre');
					else	$titre = $titreFichier;
					if ($this->input->post('auteur'))
						$auteur = $this->input->post('auteur');
					else	$auteur = "";
					if ($this->input->post('description'))
						$description = $this->input->post('description');
					else	$description = "";
					
					/*					
					//Conversion du PDF au format HTML + img
					*/
					chdir($directory); //se placer dans le repertoire de l'utilisateur
					
					$pathPDF	= $data['upload_data']['raw_name'] . ".pdf"; //location du repertoire + non du chier pdf
					$pathHTML	= $data['upload_data']['raw_name'] . ".html";
					$pathPNG	= $data['upload_data']['raw_name'] . ".png";
					
					// WINDOWS
					$command = '"C:\Program Files\Calibre2\pdftohtml.exe" -s '.$pathPDF.' >> PDFtoHTML.log 2>&1';
					// MAC OS
					//$command = '/usr/local/bin/pdftohtml -c ' . $pathPDF . ' ' . $pathHTML . ' > PDFtoHTML.log 2>&1';
					
					exec($command);
					$command = '"C:\Program Files (x86)\gs\gs9.04\bin\gswin32.exe" -q -dBATCH -dNOPAUSE -sDEVICE=jpeg -r20*20 -sOutputFile='.$pathPNG.' '.$pathPDF;
					exec($command);
					chdir("..\.."); //Retour au dossier Markus
					
					$urlfichierhtml = $directory.$data['upload_data']['raw_name']."-html.html"; //location du repertoire + nom du fichier html
				
					
					// préparation des variables pour la creation du groupe
					$donnees['emailUtilisateur']	= $this->session->userdata('email');
					$donnees['titre'] 		= $titre;
					$donnees['auteur']		= $auteur;
					$donnees['description'] 	= $description;
					$donnees['contenuOriginal']	= $urlfichierhtml; // reception du pdf>html
					$donnees['etat']		= 0;
					$donnees['dateCreation'] 	= mdate("%d/%m/%Y", time());
					// insertion du document en DB
					$idDocument = $this->model_document->addDocument('Document', $donnees);
					
					$donneesDocGrp['idGroupe']	= 0; // groupe 0 est document personnel
					$donneesDocGrp['idDocument']	= $idDocument;
					$this->model_groupe->addDocGroupe($donneesDocGrp);
					
					// réinitialise les résultats de la search
					$_SESSION['listeGroupes']	= $this->model_groupe->getGroupes()->result();
					$_SESSION['listeDocuments']	= $this->model_document->getDocuments()->result();
					
					if($idDocument>0) {
						$status = "success";
						$msg = "Bien joué ! Le document PDF est dans votre bibliothèque";
					} else {
						unlink($data['full_path']);
						$status = "error";
						$msg = "Une erreur s'est produite";	
					}
					//@unlink($_FILES[$file_element_name]);
				}
			}
			echo json_encode(array('status' => $status, 'msg' => $msg));	
		}		
	}

	/************************************************/
	/* document/files/				*/
	/*						*/
	/* BUT : afficher la bibliotheque perso (ajax)	*/
	/************************************************/
	public function files()
	{
	    $files = $this->model_document->getDocumentsPerso($this->session->userdata('email'));
	    $this->load->view('document/vue_document_uploaded', array('files' => $files->result()));
	}
	
	/****************************************/
	/* document/delete_file/<id>		*/
	/*					*/
	/* BUT : suppression d'un document	*/
	/****************************************/
	public function delete_file($file_id)
	{
	    if ($this->model_document->delDocument($file_id, $this->session->userdata('email')))
	    {
		$status = 'success';
		$msg = 'Le fichier a été détruit, comme vous le souhaitiez !';
	    }
	    else
	    {
		$status = 'error';
		$msg = 'Une erreur s\'est produite, veuillez réessayez s\il vous plait.';
	    }
	    echo json_encode(array('status' => $status, 'msg' => $msg));
	}

	
/*************************************************/
/************* FONCTIONS DE CALLBACK *************/
/*************************************************/
	
	/*************************************/
	/* vérifie l'existance du mail en DB */
	/*************************************/
	function check_mail(){
		if($this->input->post('mailInscription')) {
			$this->db->select('email');
			$this->db->from('Utilisateur');
			$this->db->where('email', $this->input->post('mailInscription'));
			if($this->db->count_all_results()>0) {
				$this->form_validation->set_message('check_mail', 'Cette adresse email est déjà utilisée !');	
				return false;
			} else {
				return true; 	
			}
		}
	}
	
	/************************************/
	/* vérifie qu'il s'agit d'une année */
	/************************************/
	function check_int(){
		if(ctype_digit($this->input->post('annee'))) {
			return true;
		} else {
			$this->form_validation->set_message('check_int', 'Saisir une année. Ex : 2010,2011,2012...');	
			return false;
		}
	}
}