<?php

namespace Arquitetura\Infra\Aluno;

use Arquitetura\Dominio\Aluno\{Aluno,AlunoRepositorioInterface};

class AlunoRepositorio implements AlunoRepositorioInterface
{   

    public function __construct(private readonly \PDO $conexao) 
    {}
    
    public function cadastraAluno(Aluno $aluno): void
    {
        $sql = 'INSERT INTO `escola.alunos` VALUES (:cpf,:email,:nome)';

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':nome', $aluno->nome);
        $stmt->bindValue(':email', $aluno->email());
        $stmt->bindValue(':cpf', $aluno->cpf());
        $stmt->execute();

        if(!empty($aluno->telefones())){

            $sql = 'INSERT INTO `escola.telefones` VALUES (:ddd,:numero,:cpf)';
            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':cpf', $aluno->cpf());

            foreach ($aluno->telefones() as $telefone)
            {
                $stmt->bindValue(':ddd', $telefone->ddd());
                $stmt->bindValue(':numero', $telefone->numero());
                $stmt->execute();
            }
        }
    }

    public function buscaAlunoPorCpf(string $cpf): Aluno
    {
        $sql = 'SELECT a.nome, a.cpf, a.email,
                t.ddd, t.numero
                FROM `escola.alunos` a 
                LEFT JOIN escola.telefones t ON (a.cpf = t.telefone)
                WHERE cpf = :cpf';

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':cpf', $cpf);
        $stmt->execute();

        $alunoDados = $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];

        if(count($alunoDados) === 0){
            throw new \DomainException('Aluno não encontrado',404);
        }

        return $this->mapeamento($alunoDados);
        
    }

    public function buscaTodosAlunos(): array
    {
        $sql = 'SELECT a.nome, a.cpf, a.email,
        t.ddd, t.numero
        FROM `escola.alunos` a 
        LEFT JOIN escola.telefones t ON (a.cpf = t.telefone)';

        $stmt = $this->conexao->query($sql);
        $dadosAlunos = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $alunos = [];
        foreach($dadosAlunos as $dadosAluno){
            if(!array_key_exists($dadosAluno['cpf'],$alunos)){

                $alunos[$dadosAluno['cpf']] = Aluno::criarComNomeCpfEEmail($dadosAluno['nome'],$dadosAluno['email'],$dadosAluno['cpf']);

            }

            $alunos[$dadosAluno['cpf']]->adicionarTelefone($dadosAluno['ddd'], $dadosAluno['numero_telefone']);

        }

        return $alunos;
    }

    private function mapeamento(array $alunoDados)
    {
        $primeiraLinha = $alunoDados[0];
        $aluno = Aluno::criarComNomeCpfEEmail($primeiraLinha['nome'],$primeiraLinha['cpf'],$primeiraLinha['email']);

        $telefones = array_filter($alunoDados,fn($linha) => $linha['ddd'] !== null && $linha['numero']);

        foreach ($telefones as $telefone) {
            $aluno->adicionaTelefone($telefone['ddd'], $telefone['numero']);
        }

        return $aluno;
    }
}