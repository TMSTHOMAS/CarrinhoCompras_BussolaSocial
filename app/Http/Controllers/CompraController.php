<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Pagamento;

class CompraController extends Controller
{
    public function index()
    {
        $itens = Item::getItens();
        return view('compra', ['itens' => $itens]);
    }

    public function processarCompra(Request $request)
    {
        $itens = Item::getItens();

        $valorTotal = array_sum(array_map(fn($item) => $item->getSubTotal(), $itens));

        if ($request->input('metodo') === 'credito_avista' || $request->input('metodo') === 'credito_parcelado') {
            session([
                'nome_titular' => $request->input('nome_titular'),
                'numero_final' => substr($request->input('numero_cartao'), -4),
                'validade' => $request->input('validade'),
            ]);
        }

        $metodo = $request->input('metodo');
        $parcelas = (int) $request->input('parcelas', 1);
        $totalFinal = Pagamento::calcularTotal($valorTotal, $metodo, $parcelas);

        return view('resultado', [
            'itens' => $itens,
            'valorTotal' => $valorTotal,
            'totalFinal' => $totalFinal,
            'metodo' => $metodo,
            'parcelas' => $parcelas,
            'nome_titular' => session('nome_titular'),
            'numero_final' => session('numero_final'),
            'validade' => session('validade'),
        ]);
    }
}
