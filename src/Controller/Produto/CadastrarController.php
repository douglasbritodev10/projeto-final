<?php

namespace App\Controller\Produto;

use App\Entity\Produto;
use App\Repository\CategoriaRepository;
use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CadastrarController extends AbstractController
{
    public function __construct(
        private ProdutoRepository $produtoRepository,
        private CategoriaRepository $categoriaRepository,
    ) {
    }

    #[Route('/app/produtos/cadastrar', name: 'cadastrar_produto', methods: 'GET')]
    public function show(): Response
    {
        return $this->render('app/produto/cadastrar.html.twig', [
            'categorias' => $this->categoriaRepository->findAll(),
        ]);
    }

    #[Route('/app/produtos', name: 'salvar_produto', methods: 'POST')]
    public function salvar(Request $request): Response
    {
        $nome = $request->request->getString('nome');
        $descricao = $request->request->getString('descricao');
        $categoria = $this->categoriaRepository->find($request->request->getInt('categoria'));
        $quantidade = $request->request->getInt('quantidade');
        $valor = $request->request->getString('valor');

        if ($nome === '' || mb_strlen($nome) > 100) {
            $this->addFlash('danger', 'Informe um nome com até 100 caracteres.');

            return $this->redirectToRoute('cadastrar_produto');
        }

        if (!$categoria) {
            $this->addFlash('danger', 'Selecione uma categoria.');

            return $this->redirectToRoute('cadastrar_produto');
        }

        if ($quantidade < 0 || !is_numeric($valor) || $valor <= 0) {
            $this->addFlash('danger', 'Informe uma quantidade e um valor válidos.');

            return $this->redirectToRoute('cadastrar_produto');
        }

        $produto = new Produto();
        $produto->setNome($nome);
        $produto->setDescricao($descricao);
        $produto->setCategoria($categoria);
        $produto->setDataCadastro(new \DateTimeImmutable());
        $produto->setQuantidadeInicial($quantidade);
        $produto->setQuantidadeDisponivel($quantidade);
        $produto->setValor($valor);

        $this->produtoRepository->salvar($produto);

        $this->addFlash('success', 'Produto cadastrado!');

        return $this->redirectToRoute('listar_produtos');
    }
}
