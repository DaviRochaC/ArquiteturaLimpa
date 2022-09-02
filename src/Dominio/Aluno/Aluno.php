<?php

namespace Arquitetura\Dominio\Aluno;

use Arquitetura\Dominio\CPF;
use Arquitetura\Dominio\Email;
use Arquitetura\Dominio\Telefone;

class Aluno
{
    private array $telefones;

    public function __construct(public readonly string $nome, private readonly Email $email, private readonly CPF $cpf)
    {}

    public static function criarComNomeCpfEEmail(string $nome, string $enderecoEmail, string $cpf): self
    {
        return new self($nome, new Email($enderecoEmail),new CPF($cpf));
    }

    public function adicionaTelefone($ddd, $numero): self
    {
        $this->telefones[] = new Telefone($ddd,$numero);

        return $this;
    }
    
    public function cpf(): string
    {
       return $this->cpf;
    }

    public function email(): string
    {
       return $this->email;
    }

    /**
     * @return Telefone[]
     */
    public function telefones(): array
    {
        return $this->telefones;
    }
}