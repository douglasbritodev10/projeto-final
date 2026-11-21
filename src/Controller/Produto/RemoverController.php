<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RemoverController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
    ) {
    }

    #[Route('/app/produtos/{id}/remover', name: 'remover_produto', requirements: ['id' => '\d+'], methods: 'POST')]
    public function remover(Produto $produto): Response
    {
        $this->produtoRepository->remover($produto);

        $this->addFlash('success', 'Produto excluído!');

        return $this->redirectToRoute('listar_produtos');
    }
}
