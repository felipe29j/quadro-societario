<?php
namespace App\Controller;

use App\Entity\Socio;
use App\Form\SocioType;
use App\Repository\SocioRepository;
use App\Service\SocioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/socio')]
class SocioController extends AbstractController
{
    private $socioService;

    public function __construct(SocioService $socioService)
    {
        $this->socioService = $socioService;
    }

    #[Route('/', name: 'app_socio_index', methods: ['GET'])]
    public function index(SocioRepository $socioRepository): Response
    {
        return $this->render('socio/index.html.twig', [
            'socios' => $socioRepository->findAll(),
        ]);
    }

    #[Route('/novo', name: 'app_socio_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $socio = new Socio();
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->socioService->createSocio($socio);
                $this->addFlash('success', 'Sócio criado com sucesso.');
                return $this->redirectToRoute('app_socio_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erro ao criar sócio: '.$e->getMessage());
            }
        }

        return $this->render('socio/create.html.twig', [
            'socio' => $socio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_socio_show', methods: ['GET'])]
    public function show(Socio $socio): Response
    {
        return $this->render('socio/show.html.twig', [
            'socio' => $socio,
        ]);
    }

    #[Route('/{id}/editar', name: 'app_socio_update', methods: ['GET', 'POST'])]
    public function update(Request $request, Socio $socio): Response
    {
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->socioService->updateSocio($socio);
                $this->addFlash('success', 'Sócio atualizado com sucesso.');
                return $this->redirectToRoute('app_socio_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erro ao atualizar sócio: '.$e->getMessage());
            }
        }

        return $this->render('socio/update.html.twig', [
            'socio' => $socio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_socio_delete', methods: ['POST'])]
    public function delete(Request $request, Socio $socio): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socio->getId(), $request->request->get('_token'))) {
            try {
                $this->socioService->deleteSocio($socio);
                $this->addFlash('success', 'Sócio excluído com sucesso.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erro ao excluir sócio: '.$e->getMessage());
            }
        } else {
            $this->addFlash('error', 'Token CSRF inválido.');
        }

        return $this->redirectToRoute('app_socio_index', [], Response::HTTP_SEE_OTHER);
    }
}
