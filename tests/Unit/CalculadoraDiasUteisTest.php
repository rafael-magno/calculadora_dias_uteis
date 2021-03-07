<?php

namespace Tests\Unit;

use App\CalculadoraDiasUteis;
use App\UserException;
use PHPUnit\Framework\TestCase;

class CalculadoraDiasUteisTest extends TestCase
{
    public function testCalculoDiasUteis()
    {
        $calculadoraDiasUteis = self::montaInstancia();
        $diasUteis = $calculadoraDiasUteis->calcularPorFaixaData('01/01/2021', '16/02/2021');

        $this->assertEquals(31, $diasUteis);
    }

    public function testDataInicioInvalida()
    {
        $calculadoraDiasUteis = self::montaInstancia();
        $mensagemErro = "";

        try {
            $calculadoraDiasUteis->calcularPorFaixaData('01/13/2021', '16/02/2021');
        } catch (UserException $e) {
            $mensagemErro = $e->getMessage();
        }

        $this->assertEquals('Data início inválida!', $mensagemErro);
    }

    public function testDataFimInvalida()
    {
        $calculadoraDiasUteis = self::montaInstancia();
        $mensagemErro = "";

        try {
            $calculadoraDiasUteis->calcularPorFaixaData('01/01/2021', '16/13/2021');
        } catch (UserException $e) {
            $mensagemErro = $e->getMessage();
        }

        $this->assertEquals('Data fim inválida!', $mensagemErro);
    }

    public function testDataInicioMaiorQueDataFim()
    {
        $calculadoraDiasUteis = self::montaInstancia();
        $mensagemErro = "";

        try {
            $calculadoraDiasUteis->calcularPorFaixaData('01/01/2021', '16/12/2020');
        } catch (UserException $e) {
            $mensagemErro = $e->getMessage();
        }

        $this->assertEquals('Data início maior que a data fim!', $mensagemErro);
    }

    public static function montaInstancia()
    {
        return new CalculadoraDiasUteis(
            ApiFeriadosTest::montaIntancia()
        );
    }
}