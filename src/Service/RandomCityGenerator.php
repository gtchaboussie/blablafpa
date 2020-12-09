<?php

namespace App\Service;

use Faker\Factory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Cette classe sert à générer une ville de manière aléatoire selon une api gouvernementale.
 */
class RandomCityGenerator{

    /**
     * Adresse de base de récupération de ville
     */
    private $apiUrl;

    /**
     * Instance de client http
     */
    private $client;

    /**
     * Injection du client http
     */
    public function __construct( HttpClientInterface $client){
        $this->client = $client;
        $this->apiUrl = "https://geo.api.gouv.fr/communes?codePostal=";
    }

    public function getRandomCity(  ){
        $faker = Factory::create('fr_FR');
        $response = null;
        
        while(!$response){
            $randomCode = $faker->randomNumber(4, true) * 10;
            $response = $this->client->request(
                'GET',
                $this->apiUrl . $randomCode
            )->toArray();
        }
        
        return $response[0]["nom"] ;

    }
}