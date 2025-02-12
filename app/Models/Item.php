<?php

namespace App\Models;

class Item
{
    public string $nome;
    public float $preco;
    public int $quantidade;

    public function __construct(string $nome, float $preco, int $quantidade)
    {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }

    public function getSubTotal(): float
    {
        return $this->preco * $this->quantidade;
    }

    public static function getItens(): array
    {
        return [
            new Item('Teclado HyperX', 450.00, 1),
            new Item('Mouse Zowie', 630.00, 1),
            new Item('Headset HyperX', 520.00, 1),
        ];
    }
}
