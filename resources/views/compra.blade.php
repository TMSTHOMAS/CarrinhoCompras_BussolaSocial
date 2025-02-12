<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
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

        h2, h3 {
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

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .error {
            color: red;
            text-align: center;
        }

        .modal {
            display: none;
            padding: 10px;
            background-color: #f8f8f8;
            border-radius: 5px;
            margin-top: 15px;
        }

        #parcelas-container {
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Carrinho de Compras</h2>

    @if(session('erro'))
        <p class="error">{{ session('erro') }}</p>
    @endif

    <h3>Itens Disponíveis:</h3>
    <ul>
        @foreach($itens as $item)
            <li>{{ $item->nome }} - R$ {{ number_format($item->preco, 2, ',', '.') }} x {{ $item->quantidade }}</li>
        @endforeach
    </ul>

    <form action="{{ route('compra.processar') }}" method="POST">
        @csrf

        <div class="form-section">
            <label>Forma de Pagamento:</label>
            <select name="metodo" id="metodo" required>
                <option value="pix">Pix (-10%)</option>
                <option value="credito_avista">Cartão Crédito à Vista (-10%)</option>
                <option value="credito_parcelado">Cartão Crédito Parcelado (+1% ao mês)</option>
            </select>
        </div>

        <div id="parcelas-container">
            <label>Parcelas:</label>
            <select name="parcelas">
                @for ($i = 2; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }}x</option>
                @endfor
            </select>
        </div>

        <div id="modal-cartao" class="modal">
            <label for="nome_titular">Nome do Titular:</label>
            <input type="text" name="nome_titular" id="nome_titular"><br>

            <label for="numero_cartao">Número do Cartão:</label>
            <input type="text" name="numero_cartao" id="numero_cartao"><br>

            <label for="validade">Data de Validade:</label>
            <input type="text" name="validade" id="validade"><br>

            <label for="cvv">Código de Segurança (CVV):</label>
            <input type="text" name="cvv" id="cvv"><br>
        </div>

        <button type="submit">Finalizar Compra</button>
    </form>

    <script>
        document.getElementById('metodo').addEventListener('change', function () {
            var metodo = this.value;

            if (metodo === 'credito_avista' || metodo === 'credito_parcelado') {
                document.getElementById('modal-cartao').style.display = 'block';
                document.getElementById('nome_titular').setAttribute('required', 'true');
                document.getElementById('numero_cartao').setAttribute('required', 'true');
                document.getElementById('validade').setAttribute('required', 'true');
                document.getElementById('cvv').setAttribute('required', 'true');
            } else {
                document.getElementById('modal-cartao').style.display = 'none';
                document.getElementById('nome_titular').removeAttribute('required');
                document.getElementById('numero_cartao').removeAttribute('required');
                document.getElementById('validade').removeAttribute('required');
                document.getElementById('cvv').removeAttribute('required');
            }

            document.getElementById('parcelas-container').style.display = metodo === 'credito_parcelado' ? 'block' : 'none';
        });
    </script>
</div>
</body>
</html>
