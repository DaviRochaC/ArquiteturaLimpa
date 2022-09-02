<?php

namespace Arquitetura\Aplicacacao\Indicacao;

use Arquitetura\Dominio\Aluno\Aluno;

interface EnviarEmailIndicacao
{

    public function enviarPara(Aluno $aluno): void;
}
