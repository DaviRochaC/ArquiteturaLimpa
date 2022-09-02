<?php

namespace Arquitetura\Dominio;

class Email implements \Stringable
{
    private string $endereco;
    public function __construct(string $endereco)
    {
        if(!filter_var($endereco,FILTER_SANITIZE_EMAIL)){
            throw new \InvalidArgumentException('Email inválido');
        }

        $this->endereco = $endereco;
    }

    public function __toString(): string
    {
       return $this->endereco;
    }
}