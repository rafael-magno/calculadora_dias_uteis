<?php

use App\ApiFeriados;
use App\CalculadoraDiasUteis;
use App\UserException;
use GuzzleHttp\Client;

require_once __DIR__.'/../vendor/autoload.php';

$httpClient = new Client();
$apiFeriados = new ApiFeriados($httpClient);
$calculadoraDiasUteis = new CalculadoraDiasUteis($apiFeriados);

$retorno = ['sucesso' => false];

try {
    $retorno['diasUteis'] = $calculadoraDiasUteis->calcularPorFaixaData($_GET['dataInicio'], $_GET['dataFim']);
    $retorno['sucesso'] = true;
} catch (UserException $e) {
    $retorno['mensagem'] = $e->getMessage();
} catch (Exception $e) {
    $retorno['mensagem'] = 'Ocorreu um erro inesperado! Tente novamente mais tarde.';
}

echo json_encode($retorno);
