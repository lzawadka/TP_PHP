<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class GeoApi {
  
  public function getCommunes($postalCode, $commune) : array
  {
    $httpClient = HttpClient::create();
    if($postalCode && $commune) {
        $response = $httpClient->request('GET', "https://geo.api.gouv.fr/communes?codePostal=".$postalCode."&nom=".$commune ."&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre");
    }
      

    // Check HTTP response
    if (200 !== $response->getStatusCode()) {
      // handle the HTTP request error
      echo strval('Error: Status Code: ' . $response->getStatusCode());
    } else {
      $content = $response->getContent();
      return json_decode($content);
    }
  }
}