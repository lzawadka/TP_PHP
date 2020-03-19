<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\EtablissementPublicApi;
use App\Service\GeoApi;

class HomeController extends AbstractController 
{
    /**
     * @Route("/", name="index")
     * @param GeoApi $geoApi
     * @param EtablissementPublicApi $etablissementPublicApi
     */
    public function getEtablissementGeo(GeoApi $geoApi, EtablissementPublicApi $etablissementPublicApi)
    {
        $returnCity = [];
        $error = "";
        if($_GET != []){
            $commune= $_GET["city"];
            $postalCode= $_GET["postal_code"];
            $communes = $geoApi->getCommunes($postalCode, $commune);
            foreach ($communes as $commune) {
                $etablissements = $etablissementPublicApi->getEtablissement($commune['code'], $_GET["type"]);
                if($etablissements != null){
                    $commune["etablissement"] = $etablissements;
                }
                array_push($returnCity,$commune);
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
            'error' => $error,
            'ville' => "",
            'codePostal' => "",
        ]);
    }
}


