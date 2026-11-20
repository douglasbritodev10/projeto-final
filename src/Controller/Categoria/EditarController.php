<?php

namespace App\Controller\Categoria;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditarController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
    ) {
    }

    #[Route('/app/categorias/{id}', name: 'editar_categoria', requirements: ['id' => '\d+'], methods: 'GET')]
    public function show(Categoria $categoria): Response
    {
        return $this->render('app/categoria/editar.html.twig', [
            'categoria' => $categoria,
        ]);
    }

    #[Route('/app/categorias/{id}', name: 'atualizar_categoria', requirements: ['id' => '\d+'], methods: 'POST')]
    public function atualizar(Categoria $categoria, Request $request): Response
    {
        $nome = $request->request->getString('nome');

        if ($nome === '' || mb_strlen($nome) > 50) {
            $this->addFlash('danger', 'Informe um nome com até 50 caracteres.');

            return $this->redirectToRoute('editar_categoria', ['id' => $categoria->getId()]);
        }

        $categoria->setNome($nome);
        $this->categoriaRepository->salvar($categoria);

        $this->addFlash('success', 'Categoria atualizada!');

        return $this->redirectToRoute('listar_categorias');
    }
}
