<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VenderController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
    ) {
    }

    #[Route('/app/produtos/{id}/vender', name: 'vender_produto', requirements: ['id' => '\d+'], methods: 'POST')]
    public function vender(Produto $produto): Response
    {
        if ($produto->getQuantidadeDisponivel() <= 0) {
            $this->addFlash('danger', 'Produto "' . $produto->getNome() . '" sem estoque!');

            return $this->redirectToRoute('listar_produtos');
        }

        $produto->setQuantidadeDisponivel($produto->getQuantidadeDisponivel() - 1);

        $this->produtoRepository->salvar($produto);

        $this->addFlash('success', 'Venda de "' . $produto->getNome() . '" registrada!');

        return $this->redirectToRoute('listar_produtos');
    }
}
