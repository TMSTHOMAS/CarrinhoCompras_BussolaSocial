<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo da Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h2, h3, p {
            text-align: center;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        strong {
            font-weight: bold;
        }

        a {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Resumo da Compra</h2>

    <h3>Itens Comprados:</h3>
    <ul>
        @foreach($itens as $item)
            <li>{{ $item->nome }} - R$ {{ number_format($item->preco, 2, ',', '.') }} x {{ $item->quantidade }} = R$ {{ number_format($item->getSubTotal(), 2, ',', '.') }}</li>
        @endforeach
    </ul>

    <p><strong>Valor Total:</strong> R$ {{ number_format($valorTotal, 2, ',', '.') }}</p>
    <p><strong>Forma de Pagamento:</strong> {{ ucfirst(str_replace('_', ' ', $metodo)) }}</p>

    @if($metodo === 'credito_parcelado')
        <p><strong>Parcelas:</strong> {{ $parcelas }}x</p>
    @endif

    <p><strong>Total Final:</strong> R$ {{ number_format($totalFinal, 2, ',', '.') }}</p>

    <a href="{{ route('compra.index') }}">Nova Compra</a>
</div>
</body>
</html>
