<?php

class EmpresaDAO
{
    
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM usuarios WHERE tipo = 'EMPRESA';";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): array
    {
        $query = 'SELECT * FROM usuarios WHERE id_usuarios = :id;';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $value = $stmt->fetch(PDO::FETCH_ASSOC);
        return $value != false ? $value : [];
    }

    public function create(
        string $nome,
        string $email,
        string $senha,
        string $endereco,
        string $telefone
    ): int|false {
        $query = 'INSERT INTO usuarios
                (nome, email, senha, tipo, endereco, telefone, status)
                VALUES
                (:nome, :email, :senha, :tipo, :endereco, :telefone, :status);';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindValue(':tipo', 'EMPRESA', PDO::PARAM_STR);
        $stmt->bindValue(':endereco', $endereco, PDO::PARAM_STR);
        $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindValue(':statususuario', 1, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $this->conn->lastInsertId();
    }

}