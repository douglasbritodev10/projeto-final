<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nome = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descricao = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categoria $categoria = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dataCadastro = null;

    #[ORM\Column]
    private ?int $quantidadeInicial = null;

    #[ORM\Column]
    private ?int $quantidadeDisponivel = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $valor = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagemUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): static
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getDataCadastro(): ?\DateTimeImmutable
    {
        return $this->dataCadastro;
    }

    public function setDataCadastro(\DateTimeImmutable $dataCadastro): static
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    public function getQuantidadeInicial(): ?int
    {
        return $this->quantidadeInicial;
    }

    public function setQuantidadeInicial(int $quantidadeInicial): static
    {
        $this->quantidadeInicial = $quantidadeInicial;

        return $this;
    }

    public function getQuantidadeDisponivel(): ?int
    {
        return $this->quantidadeDisponivel;
    }

    public function setQuantidadeDisponivel(int $quantidadeDisponivel): static
    {
        $this->quantidadeDisponivel = $quantidadeDisponivel;

        return $this;
    }

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): static
    {
        $this->valor = $valor;

        return $this;
    }

    public function getImagemUrl(): ?string
    {
        return $this->imagemUrl;
    }

    public function setImagemUrl(?string $imagemUrl): static
    {
        $this->imagemUrl = $imagemUrl;

        return $this;
    }
}
