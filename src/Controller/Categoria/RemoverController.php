<?php

namespace App\Controller\Categoria;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RemoverController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
    ) {
    }

    #[Route('/app/categorias/{id}/remover', name: 'remover_categoria', requirements: ['id' => '\d+'], methods: 'POST')]
    public function remover(Categoria $categoria): Response
    {
        try {
            $this->categoriaRepository->remover($categoria);
        } catch (ForeignKeyConstraintViolationException) {
            $this->addFlash('danger', 'Não é possível excluir uma categoria que tem produtos.');

            return $this->redirectToRoute('listar_categorias');
        }

        $this->addFlash('success', 'Categoria excluída!');

        return $this->redirectToRoute('listar_categorias');
    }
}
