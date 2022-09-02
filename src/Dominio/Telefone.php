<?php

namespace Arquitetura\Dominio;

use \InvalidArgumentException;

class Telefone
{
    private string $ddd;
    private string $numero;

    public function __construct(string $ddd, string $numero)
    {
        $this->validaTelefone($ddd,$numero);
        $this->ddd = $ddd;
        $this->numero = $numero;
    }

    public function validaTelefone(string $ddd, string $numero)
    {
        if(preg_match('/\d{2}/',$ddd) != 1) {
            throw new InvalidArgumentException('DDD é invalido');
        }

        if(preg_match('/\d{8,9}/', $numero) != 1){
            throw new InvalidArgumentException('Quantidade de caracteres do telefone é invalida');
        }
    }
    
    public function ddd(): string
    {
        return $this->ddd;
    }

    public function numero(): string
    {
        return $this->numero;
    }
}