<?php

namespace Arquitetura\Dominio\Aluno;

interface AlunoRepositorioInterface
{
    public function cadastraAluno(Aluno $aluno): void;

    public function buscaAlunoPorCpf(string $cpf): Aluno;

    public function buscaTodosAlunos(): array;
}