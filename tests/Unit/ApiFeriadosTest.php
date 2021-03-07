<?php

namespace Tests\Unit;

use App\ApiFeriados;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiFeriadosTest extends TestCase
{
    public function testRetornoFeriados()
    {
        $apiFeriados = self::montaIntancia();
        $feriados = $apiFeriados->buscarPorFaixaAno(2021, 2021);

        $esperado = array_map(fn($feriado) => $feriado['date'], self::dadosMock());

        $this->assertEquals($esperado, $feriados);
    }

    public static function montaIntancia()
    {
        $mock = self::dadosMock();

        $httpClient = new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(200, [], json_encode($mock))
            ])
        ]);

        return new ApiFeriados($httpClient);
    }

    public static function dadosMock()
    {
        return [
            ['date' => '2021-01-01'],
            ['date' => '2021-02-16'],
        ];
    }
}