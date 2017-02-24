<?php

namespace Application\Controller;

use Application\Model\Article;
use Zend\View\Model\ViewModel;

/**
 * Class ArticleController
 * @package Application\Controller
 */
class ArticleController extends AbstractController
{

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $repository = $this->getEntityManager()
            ->getRepository(Article::class);

        $articles = $repository->findAll();

        return new ViewModel(
            [
                'articles' => $articles
            ]
        );
    }

    public function createAction()
    {

        if (true === $this->getRequest()->isPost()) {
            $article = new Article();
            $article->setTitle($this->getRequest()->getPost('title'));
            $article->setContent($this->getRequest()->getPost('content'));
            $article->setCreated(new \DateTime());

            $this->getEntityManager()->persist($article);
            $this->getEntityManager()->flush();

            return $this->redirect()->toRoute(
                'article',
                [
                    'action' => 'show',
                    'id'     => $article->getId()
                ]
            );
        }

        return new ViewModel(
            [
                'action' => $this->url()->fromRoute('article', ['action' => 'create'])
            ]
        );
    }

    /**
     * @return array|ViewModel
     */
    public function showAction()
    {
        $id = $this->params('id');

        if ($id !== null) {
            $repository = $this->getEntityManager()
                ->getRepository(Article::class);

            $article = $repository->find($id);

            if ($article !== null) {

                return new ViewModel(
                    [
                        'article' => $article
                    ]
                );
            }
        }

        return $this->notFoundAction();

    }

    /**
     * @return array|\Zend\Http\Response|ViewModel
     */
    public function editAction()
    {
        if (true === $this->getRequest()->isPost()) {

            $id = $this->getRequest()->getPost('id');

            if ($id !== null) {
                $article = $this->getEntityManager()
                    ->getRepository(Article::class)
                    ->find($id);

                if ($article !== null) {
                    /** @var Article $article */
                    $article->setTitle($this->getRequest()->getPost('title'));
                    $article->setContent($this->getRequest()->getPost('content'));

                    $this->getEntityManager()->persist($article);
                    $this->getEntityManager()->flush();
                }
            }

            return $this->redirect()->toRoute('article', ['action' => 'show', 'id' => $article->getId()]);

        } else {
            $id = $this->params('id');

            if (null !== $id) {
                $article = $this->getEntityManager()
                    ->getRepository(Article::class)
                    ->find($id);

                if (null !== $article) {

                    $view = new ViewModel(
                        [
                            'article' => $article,
                            'action'  => $this->url()->fromRoute('article', ['action' => 'edit'])
                        ]
                    );

                    $view->setTemplate('application/article/create');
                    return $view;
                }
            }

            return $this->notFoundAction();
        }
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction()
    {
        $id = $this->params('id');

        if (null !== $id) {
            $article = $this->getEntityManager()
                ->getRepository(Article::class)
                ->find($id);

            if (null !== $article) {
                $this->getEntityManager()->remove($article);
                $this->getEntityManager()->flush();

                return $this->redirect()->toRoute('article');
            }
        }

        return $this->notFoundAction();

    }

}