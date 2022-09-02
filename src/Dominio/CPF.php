<?php

namespace Arquitetura\Dominio;

class CPF implements \Stringable
{
    private string $cpf;
    
    public function __construct(string $cpf)
    {
        $this->validaCPF($cpf);
        $this->cpf = $cpf;
    }

    private function validaCPF($cpf){

        if(strlen($cpf) != 14){
            throw new \InvalidArgumentException('Cpf se encontra no formato inválido');
        }
        $options = [
            'options' => [
              'regexp' =>  '/\d{3}\.\d{3}\.\d{3}\-\d{2}/'
                ]
        ];

        if(!filter_var($cpf,FILTER_VALIDATE_REGEXP,$options)){
            throw new \InvalidArgumentException('Cpf se encontra no formato inválido');
        }
    }

    public function __toString(): string
    {
        return $this->cpf;
    }
}