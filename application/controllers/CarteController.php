<?php



class CarteController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        try{
            //récupération des données
            $client = new Zend_Http_Client('https://recrutement.local-trust.com/test/cards/57187b7c975adeb8520a283c');
            $response = $client->request('GET');
            $jsonData = $response->getBody();
            $dataObj = json_decode($jsonData);

            //data
            $exerciceId = $dataObj->exerciceId;
            
            //tableau trié avec ajout de categoryOrder et valueOrder
            $tritab = $this->triCartes($dataObj);
            
            // Envoi du résultat à l'API
            $client->request('POST','https://recrutement.local-trust.com/test/'.$exerciceId);
            $client->setRawData($tritab, 'application/json');

            //ajout du code de statut de la requête
            $code = $client->getLastResponse()->getStatus(); 
            $tritab["code"] = $code;

            
            $this->view->cards = $dataObj->data->cards;
            $this->view->sortCards = $tritab["cards"];

        } catch (Exception $e) {
            echo $e->getMessage();
        }
        //echo json_encode($tritab);
    }

    private function triCartes($exercice){

        $exerciceId = $exercice->exerciceId;
        $cards = $exercice->data->cards;
        $categoryOrder = $exercice->data->categoryOrder;
        $valueOrder = $exercice->data->valueOrder;

        //tableau pour les données triées
        $tricards = [];

        //Extraction du tableau des cartes en deux dimensions
        foreach ($cards as $card) {
            
            //extraction des index des catégories et des valeurs
            $categoryIndex = array_search($card->category, $categoryOrder);
            $valueIndex = array_search($card->value, $valueOrder);
            
            //rassembler la catégorie et la valeur en un tableau de deux dimensions
            $tricards[$categoryIndex][$valueIndex] = ["category" => $card->category, "value" => $card->value];

            

        }
        //trier le tableau 
        $this->RecursiveSort($tricards);

        //fusisonner le tabelau trié de deux dimensions en une seule dimension
        $tricards = call_user_func_array("array_merge", $tricards);
        
        //mettre les données dans un tableau résultat selon le corps de la requête donnée
        $result = [];

        //$result["exerciceId"] = $exerciceId;
        $result["cards"] = $tricards;
        $result["categoryOrder"] = $categoryOrder;
        $result["valueOrder"] = $valueOrder;

       return $result;
    }

    //Tri récursif des donnnées selon l'index du tableau multi-dimensions
    private function RecursiveSort(&$array){
        if(is_array($array)){
            //tableau une seule dimension
            if(count($array) == count($array , COUNT_RECURSIVE)){
                ksort($array);
            }
            else{
                //plus d'une dimension
                ksort($array);
                foreach ($array as &$arr) {
                    $this->RecursiveSort($arr);
                }
            }
        }
        else{
            return false;
        }

        return true;
    }

}

