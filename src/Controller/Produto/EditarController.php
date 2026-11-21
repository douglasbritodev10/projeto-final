<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditarController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository,
    ) {
    }

    #[Route('/app/produtos/{id}', name: 'editar_produto', requirements: ['id' => '\d+'], methods: 'GET')]
    public function show(Produto $produto): Response
    {
        return $this->render('app/produto/editar.html.twig', [
            'produto' => $produto,
            'categorias' => $this->categoriaRepository->findAll(),
        ]);
    }

    #[Route('/app/produtos/{id}', name: 'atualizar_produto', requirements: ['id' => '\d+'], methods: 'POST')]
    public function atualizar(Produto $produto, Request $request): Response
    {
        $nome = $request->request->getString('nome');
        $descricao = $request->request->getString('descricao');
        $categoria = $this->categoriaRepository->find($request->request->getInt('categoria'));
        $valor = $request->request->getString('valor');

        if ($nome === '' || mb_strlen($nome) > 100) {
            $this->addFlash('danger', 'Informe um nome com até 100 caracteres.');

            return $this->redirectToRoute('editar_produto', ['id' => $produto->getId()]);
        }

        if (!$categoria) {
            $this->addFlash('danger', 'Selecione uma categoria.');

            return $this->redirectToRoute('editar_produto', ['id' => $produto->getId()]);
        }

        if (!is_numeric($valor) || $valor <= 0) {
            $this->addFlash('danger', 'Informe um valor válido.');

            return $this->redirectToRoute('editar_produto', ['id' => $produto->getId()]);
        }

        $produto->setNome($nome);
        $produto->setDescricao($descricao);
        $produto->setCategoria($categoria);
        $produto->setValor($valor);

        $this->produtoRepository->salvar($produto);

        $this->addFlash('success', 'Produto atualizado!');

        return $this->redirectToRoute('listar_produtos');
    }
}
