<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdicionarController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
    ) {
    }

    #[Route('/app/produtos/{id}/adicionar', name: 'adicionar_produto', requirements: ['id' => '\d+'], methods: 'POST')]
    public function adicionar(Produto $produto): Response
    {
        $produto->setQuantidadeDisponivel($produto->getQuantidadeDisponivel() + 1);

        $this->produtoRepository->salvar($produto);

        $this->addFlash('success', 'Estoque de "' . $produto->getNome() . '" aumentado!');

        return $this->redirectToRoute('listar_produtos');
    }
}
