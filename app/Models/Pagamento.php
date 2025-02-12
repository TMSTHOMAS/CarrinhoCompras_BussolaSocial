<?php

namespace App\Models;

class Pagamento
{
    public static function calcularTotal(float $valorTotal, string $metodo, int $parcelas = 1): float
    {
        if ($metodo === 'pix' || $metodo === 'credito_avista') {
            return self::aplicarDesconto($valorTotal, 10);
        }

        if ($metodo === 'credito_parcelado') {
            if ($parcelas < 2 || $parcelas > 12) {
                throw new \InvalidArgumentException("O número de parcelas deve ser entre 2 e 12.");
            }
            return self::aplicarJuros($valorTotal, 1, $parcelas);
        }

        throw new \InvalidArgumentException("Método de pagamento inválido.");
    }

    private static function aplicarDesconto(float $valor, float $percentual): float
    {
        return $valor * (1 - $percentual / 100);
    }

    private static function aplicarJuros(float $valor, float $taxa, int $parcelas): float
    {
        return $valor * pow((1 + $taxa / 100), $parcelas);
    }
}
