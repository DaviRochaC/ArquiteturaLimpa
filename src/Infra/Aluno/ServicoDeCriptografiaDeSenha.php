<?php

namespace Arquitetura\Infra\Aluno;

use Arquitetura\Dominio\Aluno\EncriptadorDeSenhaInterface;

class ServicoDeCriptografiaDeSenha implements EncriptadorDeSenhaInterface
{
    public function encripta(string $senha): string
    {
        return password_hash($senha, PASSWORD_ARGON2I);
    }

    public function verifica(string $senhaEmTexto, string $senhaCriptografada): bool
    {
        return password_verify($senhaEmTexto, $senhaCriptografada);
    }
}