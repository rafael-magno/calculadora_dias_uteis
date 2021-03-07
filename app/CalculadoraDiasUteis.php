<?php 

namespace App;

class CalculadoraDiasUteis
{
    private ApiFeriados $apiFeriados;
    
    public function __construct(ApiFeriados $apiFeriados)
    {
        $this->apiFeriados = $apiFeriados;
    }

    public function calcularPorFaixaData(string $dataInicio, string $dataFim): int
    {
        list($dia, $mes, $anoInicio) = explode('/', $dataInicio);
        $data = $anoInicio . '-' . $mes . '-' . $dia;

        if (!checkdate($mes, $dia, $anoInicio)) {
            throw new UserException('Data início inválida!');
        }
        
        list($dia, $mes, $anoFim) = explode('/', $dataFim);
        $dataFim = $anoFim . '-' . $mes . '-' . $dia;

        if (!checkdate($mes, $dia, $anoFim)) {
            throw new UserException('Data fim inválida!');
        }

        if (strtotime($data) > strtotime($dataFim)) {
            throw new UserException('Data início maior que a data fim!');
        }

        $feriados = $this->apiFeriados->buscarPorFaixaAno($anoInicio, $anoFim);

        $diasUteis = 0;

        while (strtotime($data) <= strtotime($dataFim)) {
            if (date('N', strtotime($data)) < 6 && !in_array($data, $feriados)) {
                $diasUteis++;
            }

            $data = date('Y-m-d', strtotime($data . ' +1 day'));
        }

        return $diasUteis;
    }
}