<?php

class EcrireController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function ecrireAction(){
        if($_POST){
            if($_POST['type'] == 1){
            	$idEtudiant = $_POST["id"];
            	$this->insertAbsenceEtudiant($idEtudiant);
            }
            else if ($_POST['type'] == 2){
                $idEtudiant = $_POST["id"];
                $this->insertPresenceEtudiant($idEtudiant);
            }
            
        }
    }
    
    public function insertAbsenceEtudiant($idEtudiant){
        $date = date("d/m/y");
        
        $bdd = $this->bddConnect();
        $bdd->exec("INSERT INTO absences(id_etudiant,date_absence) VALUES('$idEtudiant','$date')");
    }
    
    public function insertPresenceEtudiant($idEtudiant){
    	$date = date("d/m/y");
    
    	$bdd = $this->bddConnect();
    	$bdd->exec("INSERT INTO presences(id_etudiant,date_presence) VALUES('$idEtudiant','$date')");
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