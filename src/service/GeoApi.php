<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class GeoApi {
  
  function getCommunes(string $postalCode, string $commune) : array 
  {
    $httpClient = HttpClient::create();
    if($cityName === ""){
        $response = $httpClient->request('GET', "https://geo.api.gouv.fr/communes?codePostal=" . $postalcode . "&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre");
    } elseif ($postalcode === ""){
        $response = $httpClient->request('GET', "https://geo.api.gouv.fr/communes?nom=" . $cityName . "&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre");
    }
    else {
        $response = $httpClient->request('GET', "https://geo.api.gouv.fr/communes?codePostal=" . $postalcode . "&nom=" . $cityName . "&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre");
    }
      

    // Check HTTP response
    if (200 !== $response->getStatusCode()) {
      // handle the HTTP request error
      echo strval('Error: Status Code: ' . $response->getStatusCode());
    } else {
      $content = $response->getContent();
      return json_decode($responseApi);
    }
  }
}