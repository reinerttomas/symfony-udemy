<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\Traits\FlashTrait;
use App\Dto\ArticleCreateRequest;
use App\Dto\ArticleUpdateRequest;
use App\Exception\Logic\NotFoundException;
use App\Exception\ORM\ORMStoreException;
use App\Form\ArticleCreateType;
use App\Form\ArticleUpdateType;
use App\Services\ArticleCreateService;
use App\Services\ArticleFetchService;
use App\Services\ArticleRemoveService;
use App\Services\ArticleUpdateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    use FlashTrait;

    private ArticleFetchService $articleFetchService;
    private ArticleCreateService $articleCreateService;
    private ArticleUpdateService $articleUpdateService;
    private ArticleRemoveService $articleRemoveService;

    public function __construct(
        ArticleFetchService $articleFetchService,
        ArticleCreateService $articleCreateService,
        ArticleUpdateService $articleUpdateService,
        ArticleRemoveService $articleRemoveService,
    ) {
        $this->articleFetchService = $articleFetchService;
        $this->articleCreateService = $articleCreateService;
        $this->articleUpdateService = $articleUpdateService;
        $this->articleRemoveService = $articleRemoveService;
    }

    #[Route('/article', name: 'admin-article-list')]
    public function index(): Response
    {
        $articles = $this->articleFetchService->getAllNotRemoved();

        return $this->render(
            'admin/article/index.html.twig',
            [
                'articles' => $articles,
            ],
        );
    }

    #[Route('/article/detail/{id}', name: 'admin-article-detail')]
    public function detail(int $id): Response
    {
        try {
            $article = $this->articleFetchService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        return $this->render(
            'admin/article/detail.html.twig',
            [
                'article' => $article,
            ],
        );
    }

    #[Route('/article/create', name: 'admin-article-create')]
    public function create(Request $request): Response
    {
        $articleCreateRequest = new ArticleCreateRequest();

        $form = $this->createForm(ArticleCreateType::class, $articleCreateRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $article = $this->articleCreateService->createFromRequest($articleCreateRequest);
                $this->addFlashSuccess('Article create success.');

                return $this->redirectToRoute(
                    'admin-article-detail',
                    [
                        'id' => $article->getId(),
                    ],
                );
            } catch (ORMStoreException) {
                $this->addFlashError('Article form error.');
            }
        }

        return $this->render(
            'admin/article/create.html.twig',
            [
                'form' => $form->createView(),
            ],
        );
    }

    #[Route('/article/update/{id}', name: 'admin-article-update')]
    public function update(Request $request, int $id): Response
    {
        try {
            $article = $this->articleFetchService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        $articleUpdateRequest = ArticleUpdateRequest::from($article);

        $form = $this->createForm(ArticleUpdateType::class, $articleUpdateRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $article = $this->articleUpdateService->updateFromRequest($article, $articleUpdateRequest);
                $this->addFlashSuccess('Article update success.');

                return $this->redirectToRoute(
                    'admin-article-detail',
                    [
                        'id' => $article->getId(),
                    ],
                );
            } catch (ORMStoreException) {
                $this->addFlashError('Article form error.');
            }
        }

        return $this->render(
            'admin/article/update.html.twig',
            [
                'form' => $form->createView(),
            ],
        );
    }

    #[Route('/article/delete/{id}', name: 'admin-article-delete')]
    public function delete(int $id): Response
    {
        try {
            $article = $this->articleFetchService->get($id);
        } catch (NotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage(), $e);
        }

        try {
            $this->articleRemoveService->remove($article);
            $this->addFlashSuccess('Article remove success.');
        } catch (ORMStoreException) {
            $this->addFlashError('Article delete error.');
        }

        return $this->redirectToRoute('admin-article-list');
    }
}
