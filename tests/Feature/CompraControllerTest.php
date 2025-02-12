<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Pagamento;

class CompraControllerTest extends TestCase
{
    /** @test */
    public function itCalculatesTotalValue()
    {
        $itens = Item::getItens();

        $valorTotal = array_sum(array_map(fn($item) => $item->getSubTotal(), $itens));

        $requestData = [
            'metodo' => 'credito_avista',
            'nome_titular' => 'João da Silva',
            'numero_cartao' => '1234567812345678',
            'validade' => '12/25',
            'parcelas' => 1,
        ];

        $response = $this->post('/processar', $requestData);

        $totalFinal = Pagamento::calcularTotal($valorTotal, 'credito_avista', 1);

        $response->assertStatus(200);
        $response->assertViewIs('resultado');
        $response->assertViewHas('itens', $itens);
        $response->assertViewHas('valorTotal', $valorTotal);
        $response->assertViewHas('totalFinal', $totalFinal);
        $response->assertViewHas('metodo', 'credito_avista');
        $response->assertViewHas('parcelas', 1);
        $response->assertViewHas('nome_titular', 'João da Silva');
    }
}
