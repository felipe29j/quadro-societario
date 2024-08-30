<?php
namespace App\Controller;

use App\Entity\Empresa;
use App\Form\EmpresaType;
use App\Repository\EmpresaRepository;
use App\Service\EmpresaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/empresa')]
class EmpresaController extends AbstractController
{
    private $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;

    }

    #[Route('/', name: 'app_empresa_index', methods: ['GET'])]
    public function index(EmpresaRepository $empresaRepository): Response
    {
        return $this->render('empresa/index.html.twig', [
            'empresas' => $empresaRepository->findAll(),
        ]);
    }

    #[Route('/novo', name: 'app_empresa_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $empresa = new Empresa();
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->empresaService->createEmpresa($empresa);
                $this->addFlash('success', 'Empresa criada com sucesso.');
                return $this->redirectToRoute('app_empresa_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erro ao criar empresa: '.$e->getMessage());
            }
        }

        return $this->render('empresa/create.html.twig', [
            'empresa' => $empresa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_empresa_show', methods: ['GET'])]
    public function show(Empresa $empresa): Response
    {
        return $this->render('empresa/show.html.twig', [
            'empresa' => $empresa,
        ]);
    }

    #[Route('/{id}/editar', name: 'app_empresa_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Empresa $empresa): Response
    {
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->empresaService->updateEmpresa($empresa);
                $this->addFlash('success', 'Empresa atualizada com sucesso.');
                return $this->redirectToRoute('app_empresa_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erro ao atualizar empresa: '.$e->getMessage());
            }
        }

        return $this->render('empresa/update.html.twig', [
            'empresa' => $empresa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_empresa_delete', methods: ['POST'])]
    public function delete(Request $request, Empresa $empresa): Response
    {
        if ($this->isCsrfTokenValid('delete'.$empresa->getId(), $request->request->get('_token'))) {
            try {
                $this->empresaService->deleteEmpresa($empresa);
                $this->addFlash('success', 'Empresa excluída com sucesso.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erro ao excluir empresa: '.$e->getMessage());
            }
        } else {
            $this->addFlash('error', 'Token CSRF inválido.');
        }

        return $this->redirectToRoute('app_empresa_index', [], Response::HTTP_SEE_OTHER);
    }
}
