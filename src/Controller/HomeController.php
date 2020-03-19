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
            $communes = $geoAPi->getCommunes($city,$postalCode);
            foreach ($communes as $commune) {
                $etablissements = $etablissementPublicApi->getEtablissement($commune['code'], $_GET["type"]);
                if($etablissements != null){
                    $commune["etablissement"] = $etablissements;
                }
                array_push($returnCommune,$commune);
            }
            if(array_key_exists("error", $communes)){
                $error = $communes["error"];
            }
            else if(array_key_exists("error", $etablissements)){
                $error = $etablissements["error"];
            }
            else if($communes == []){
                $error = "Aucune ville n'a été trouvé.";
            }
            return $this->render('base.html.twig', [
                'citys' => $returnCommune,
                'error' => $error,
                'ville' => $_GET["city"],
                'codePostal' => $_GET["postal_code"],
            ]);
        }
        return $this->render('base.html.twig', [
            'citys' => $returnCommune,
            'ville' => "",
            'codePostal' => "",
            'error' => $error,
        ]);
    }
}


