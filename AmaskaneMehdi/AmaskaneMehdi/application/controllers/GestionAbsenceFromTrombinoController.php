<?php

class GestionAbsenceFromTrombinoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function vueprincipaleAction()
    {
        $bdd = $this->bddConnect();
         
        $sql = "SELECT id_etudiant, nom, url_image FROM etudiant";
         
        $reponse = $bdd->query($sql);
         
        while($data=$reponse->fetch()){
        		
        	$donnees[]= $data;
        }
         
        $this->view->data = $donnees ;
    }
    
    
    public function sauvefluxAction()
    {
     $xml = simplexml_load_file('https://picasaweb.google.com/data/feed/base/user/107401320610499259896/albumid/6065229773950541889?alt=rss&kind=photo&authkey=Gv1sRgCNak7e60l-7VlgE&hl=fr');
        
    $bdd = $this->bddConnect();
        
        foreach ($xml->channel->item as $etu){
            $nom = $etu->title;
            $urlPhoto = $etu->enclosure['url'];
            
             $bdd->exec("INSERT INTO etudiant(nom,url_image) VALUES('$nom','$urlPhoto')");
             
             echo "OK";
        }   
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

