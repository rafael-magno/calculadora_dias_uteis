<?php 

namespace App;

use GuzzleHttp\Client;

class ApiFeriados
{
    const URL = 'https://date.nager.at/api/v2/publicholidays/';
    const PAIS = 'BR';

    private Client $httpClient;
    
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function buscarPorFaixaAno(int $anoInicio, int $anoFim): array
    {
        $feriados = [];
        $ano = $anoInicio;

        while ($ano <= $anoFim) {
            $url = self::URL . $ano . '/' . self::PAIS;
            $response = $this->httpClient->request('GET', $url);
            
            $feriadosAno = json_decode($response->getBody());
            $feriadosAno = array_map(fn($feriado) => $feriado->date, $feriadosAno);
            $feriados = array_merge($feriados, $feriadosAno);
            
            $ano++;
        }

        return $feriados;
    }
}