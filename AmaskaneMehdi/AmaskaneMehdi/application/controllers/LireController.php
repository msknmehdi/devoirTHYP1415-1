<?php

class LireController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function lireAction()
    {
        if($_POST){
        	if($_POST['type'] == 1){
        		$idEtudiant = $_POST["id"];
        		$this->lirePresenceEtudiant($idEtudiant);
        	}
        	else if ($_POST['type'] == 2){
        		$idEtudiant = $_POST["id"];
        		$this->lireAbsenceEtudiant($idEtudiant);
        	}
        	else if ($_POST['type'] == 3){
        		$idEtudiant = $_POST["id"];
        		$this->getlisteAbsencesPresencesEtudiant($idEtudiant);
        	}
        
        }
    }
    
    public function lireAbsenceEtudiant($idEtudiant){
    	$bdd = $this->bddConnect();
    	$sql = "SELECT date_absence FROM absences WHERE id_etudiant ='$idEtudiant'";
    	$reponse = $bdd->query($sql);
    
    	while($donnee = $reponse->fetch()){
    		$data[] = $donnee;
    	}
    	$this->view->data = $data;
    }
    
    public function lirePresenceEtudiant($idEtudiant){
        $bdd = $this->bddConnect();
        $sql = "SELECT date_presence FROM presences WHERE id_etudiant ='$idEtudiant'";
        $reponse = $bdd->query($sql);
        
        while($donnee = $reponse->fetch()){
            $data[] = $donnee;
        }
        $this->view->data = $data;
    }
    
    public function getlisteAbsencesPresencesEtudiant($idEtudiant){
    	$bdd = $this->bddConnect();
    	$sql = "SELECT e.id_etudiant,date_absence, date_presence FROM etudiant e
                INNER JOIN absences a on a.id_etudiant = e.id_etudiant
                INNER JOIN presences p on p.id_etudiant = e.id_etudiant
                WHERE e.id_etudiant ='$idEtudiant'";
    	
    	$reponse = $bdd->query($sql);
    
    	while($donnee = $reponse->fetch()){
    		$data[] = $donnee;
    	}
    	$this->view->data = $data;
    }
    
    static function bddConnect(){
    
    	try
    	{
    		$bdd = new PDO('mysql:host=localhost;dbname=flux_etu', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    	}
    	catch (Exception $e)
    	{
    		echo "<div style='background: antiquewhite;text-align:center;'>Veuillez vérifier si la base de données existe.<br/> Si non. Executez sur votre serveur Mysql, le fichier creationBDD+Donnees.sql,<br/> disponible dans le dossier Base de données du site web.</div>";
    	}
    	return $bdd;
    }

}

