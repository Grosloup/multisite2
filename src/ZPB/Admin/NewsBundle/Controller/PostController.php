<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 16:41
 */
 /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/

namespace ZPB\Admin\NewsBundle\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use ZPB\Admin\CommonBundle\Controller\BaseController;
use ZPB\Admin\NewsBundle\Entity\Post;
use ZPB\Admin\NewsBundle\Form\Type\PostType;

class PostController extends BaseController
{
    public function listAction($page=1, Request $request)
    {
        $postsPerPage = $this->get('zpb.admin.news.post_cookie')->get('ppp', 5);

        $posts = $this->getRepo('ZPBAdminNewsBundle:Post')->findAllPublished();

        return $this->render('ZPBAdminNewsBundle:Post:list.html.twig', ['postsPerPage'=>$postsPerPage, 'posts'=>$posts]);
    }

    public function listDraftAction($page=1, Request $request)
    {
        $posts = $this->getRepo('ZPBAdminNewsBundle:Post')->findAllDraft();

        return $this->render('ZPBAdminNewsBundle:Post:list_draft.html.twig', ['posts'=>$posts]);
    }

    public function listArchiveAction()
    {
        //TODO
    }

    public function listTrashAction()
    {
        //TODO
    }

    public function changePostsPerPageAction(Request $request)
    {
        $postsPerPage = $request->query->get('posts_per_page', $this->container->getParameter('zpb.admin.news.post_cookie.params')['ppp']);

        $postCookie = $this->get('zpb.admin.news.post_cookie');
        $postCookie->set('ppp', $postsPerPage);
        $response = new RedirectResponse($this->generateUrl('zpb_admin_news_posts_list'));

        $response->headers->setCookie($postCookie->makeCookie());
        return $response;
    }

    public function writeAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(new PostType(), $post, ['em'=>$this->getManager()]);
        $targets = $this->getRepo('ZPBAdminNewsBundle:PostTarget')->findAll();

        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getManager();
            $repo = $em->getRepository('ZPBAdminNewsBundle:Post');
            $repo->solveTags($post);


            if($form->get('save_publish')->isClicked()){
                $repo->publish($post);
            }

            $em->persist($post);

            $repo->solveFronts($post);
            $em->flush();

            return $this->redirect($this->generateUrl('zpb_admin_news_posts_list'));
        }
        $postStatus = $this->getRepo('ZPBAdminNewsBundle:Post')->getStatus($post);
        return $this->render('ZPBAdminNewsBundle:Post:write.html.twig',['form'=>$form->createView(),'postStatus'=>$postStatus,'post'=>$post,'targets'=>$targets]);
    }

    public function editAction($id, Request $request)
    {
        $post = $this->getRepo('ZPBAdminNewsBundle:Post')->find($id);

        if(!$post){
            //TODO PostNotFoundException
            throw $this->createNotFoundException();
        }
        $form = $this->createForm(new PostType(), $post, ['em'=>$this->getManager()]);
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getManager();
            $repo = $em->getRepository('ZPBAdminNewsBundle:Post');
            $repo->solveTags($post);


            if($form->get('save_publish')->isClicked()){
                $repo->publish($post);
            }

            $em->persist($post);

            $repo->solveFronts($post, $em);
            $em->flush();

            return $this->redirect($this->generateUrl('zpb_admin_news_posts_list'));
        }
        $postStatus = $this->getRepo('ZPBAdminNewsBundle:Post')->getStatus($post);
        return $this->render('ZPBAdminNewsBundle:Post:edit.html.twig',['form'=>$form->createView(),'postStatus'=>$postStatus,'post'=>$post]);
    }

    public function dropAction($id, Request $request)
    {
        $post = $this->getRepo('ZPBAdminNewsBundle:Post')->find($id);

        if(!$post){
            //TODO PostNotFoundException
            throw $this->createNotFoundException();
        }
        $this->getRepo('ZPBAdminNewsBundle:Post')->drop($post);
        $em = $this->getManager();
        $em->persist($post);
        $em->flush();

        return $this->redirect($this->generateUrl('zpb_admin_news_posts_list'));
    }

    public function deleteAction($id, Request $request)
    {
        //TODO

        $post = $this->getRepo('ZPBAdminNewsBundle:Post')->find($id);

        if(!$post){
            //TODO PostNotFoundException
            throw $this->createNotFoundException();
        }


        return $this->redirect($this->generateUrl('zpb_admin_news_posts_list'));
    }
}
