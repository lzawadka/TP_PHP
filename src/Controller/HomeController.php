<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\EtablissementPublicApi;
use App\Service\GeoAPi;

class HomeController extends AbstractController 
{
  /**
     * @Route("/", name="index")
     * @param GeoAPi $geoAPi
     * @param EtablissementPublicApi $etablissementPublicApi
     */
    public function getEtablissementGeo(GeoAPi $geoAPi, EtablissementPublicApi $etablissementPublicApi)
    {
        $returnCity = [];
        $error = "";
        if($_GET != []){
            $city= $_GET["city"];
            $postalCode= $_GET["postal_code"];
            $citys = $geoAPi->getCommunes($city,$postalCode);
            foreach ($citys as $city) {
                $etablissements = $etablissementPublicApi->getEtablissement($city['code'], $_GET["type"]);
                if($etablissements != null){
                    $city["etablissement"] = $etablissements;
                }
                array_push($returnCity,$city);
            }
            if(array_key_exists("error", $citys)){
                $error = $citys["error"];
            }
            else if(array_key_exists("error", $etablissements)){
                $error = $etablissements["error"];
            }
            else if($citys == []){
                $error = "Aucune ville trouvé.";
            }
            return $this->render('base.html.twig', [
                'citys' => $returnCity,
                'error' => $error,
                'ville' => $_GET["city"],
                'codePostal' => $_GET["postal_code"],
            ]);
        }
        return $this->render('base.html.twig', [
            'citys' => $returnCity,
            'ville' => "",
            'codePostal' => "",
            'error' => $error,
        ]);
    }
}


