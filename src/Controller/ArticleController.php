<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\Logic\NotFoundException;
use App\Exception\ORM\ORMStoreException;
use App\Form\CreateArticleRequest;
use App\Form\CreateArticleType;
use App\Form\UpdateArticleRequest;
use App\Form\UpdateArticleType;
use App\Services\FetchArticleService;
use App\Services\CreateArticleService;
use App\Services\RemoveArticleService;
use App\Services\UpdateArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    use FlashTrait;

    private FetchArticleService $fetchArticleService;
    private CreateArticleService $createArticleService;
    private UpdateArticleService $updateArticleService;
    private RemoveArticleService $removeArticleService;

    public function __construct(
        FetchArticleService  $fetchArticleService,
        CreateArticleService $createArticleService,
        UpdateArticleService $updateArticleService,
        RemoveArticleService $removeArticleService,
    ) {
        $this->fetchArticleService = $fetchArticleService;
        $this->createArticleService = $createArticleService;
        $this->updateArticleService = $updateArticleService;
        $this->removeArticleService = $removeArticleService;
    }


    #[Route('/article', name: 'article-list')]
    public function index(): Response
    {
        $articles = $this->fetchArticleService->getAllNotRemoved();

        return $this->render(
            'article/index.html.twig',
            [
                'articles' => $articles,
            ]
        );
    }

    #[Route('/article/detail/{id}', name: 'article-detail')]
    public function detail(int $id): Response
    {
        try {
            $article = $this->fetchArticleService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->render(
            'article/detail.html.twig',
            [
                'article' => $article,
            ]
        );
    }

    #[Route('/article/create', name: 'article-create')]
    public function create(Request $request): Response
    {
        $createArticleRequest = new CreateArticleRequest();

        $form = $this->createForm(CreateArticleType::class, $createArticleRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $article = $this->createArticleService->createFromRequest($createArticleRequest);
                $this->addFlashSuccess('Article create success.');

                return $this->redirectToRoute(
                    'article-detail',
                    [
                        'id' => $article->getId(),
                    ]
                );
            } catch (ORMStoreException $e) {
                $this->addFlashError('Article form error.');
            }
        }

        return $this->render(
            'article/create.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/article/update/{id}', name: 'article-update')]
    public function update(Request $request, int $id): Response
    {
        try {
            $article = $this->fetchArticleService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $updateArticleRequest = UpdateArticleRequest::from($article);

        $form = $this->createForm(UpdateArticleType::class, $updateArticleRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $article = $this->updateArticleService->updateFromRequest($article, $updateArticleRequest);
                $this->addFlashSuccess('Article update success.');

                return $this->redirectToRoute(
                    'article-detail',
                    [
                        'id' => $article->getId(),
                    ]
                );
            } catch (ORMStoreException $e) {
                $this->addFlashError('Article form error.');
            }
        }

        return $this->render(
            'article/update.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/article/delete/{id}', name: 'article-delete')]
    public function delete(int $id): Response
    {
        try {
            $article = $this->fetchArticleService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        try {
            $this->removeArticleService->remove($article);
            $this->addFlashSuccess('Article remove success.');
        } catch (ORMStoreException $e) {
            $this->addFlashError('Article delete error.');
        }

        return $this->redirectToRoute('article-list');
    }
}