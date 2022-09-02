<?php

namespace Arquitetura\Dominio\Aluno;

interface EncriptadorDeSenhaInterface
{
    public function encripta(string $senha): string;

    public function verifica(string $senhaEmTexto, string $senhaCriptografada): bool;
}