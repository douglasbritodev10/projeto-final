<?php

namespace App\Controller\Categoria;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CadastrarController extends AbstractController
{
    public function __construct(
        private CategoriaRepository $categoriaRepository,
    ) {
    }

    #[Route('/app/categorias/cadastrar', name: 'cadastrar_categoria', methods: 'GET')]
    public function show(): Response
    {
        return $this->render('app/categoria/cadastrar.html.twig');
    }

    #[Route('/app/categorias', name: 'salvar_categoria', methods: 'POST')]
    public function salvar(Request $request): Response
    {
        $nome = $request->request->getString('nome');

        if ($nome === '' || mb_strlen($nome) > 50) {
            $this->addFlash('danger', 'Informe um nome com até 50 caracteres.');

            return $this->redirectToRoute('cadastrar_categoria');
        }

        $categoria = new Categoria();
        $categoria->setNome($nome);

        $this->categoriaRepository->salvar($categoria);

        $this->addFlash('success', 'Categoria criada!');

        return $this->redirectToRoute('listar_categorias');
    }
}
