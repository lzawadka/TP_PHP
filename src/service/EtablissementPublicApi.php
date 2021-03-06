<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementPublicApi {
  
  public function getEtablissement($postalCode, $type) : array
  {
    $httpClient = HttpClient::create();
    $response = $httpClient->request('GET', 'https://etablissements-publics.api.gouv.fr/v3/communes/' . $postalCode . "/" . $type);

    // Check HTTP response
    if ($response->getStatusCode() !== 200) {
      // handle the HTTP request error
      echo strval('Error: Status Code: ' . $response->getStatusCode());
    } else {
      $content = $response->getContent();
      return json_decode($content, true);
    }
  }
}
