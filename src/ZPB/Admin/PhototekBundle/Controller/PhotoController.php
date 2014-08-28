<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/08/14
 * Time: 10:00
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

namespace ZPB\Admin\PhototekBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use ZPB\Admin\CommonBundle\Controller\BaseController;
use ZPB\Admin\PhototekBundle\Form\Type\PhotoType;

class PhotoController extends BaseController
{
    public function listAction($page = 1)
    {
        $photos = $this->getRepo('ZPBAdminPhototekBundle:Photo')->findAllByGroupedPositioned(); //TODO pagination
        return $this->render('ZPBAdminPhototekBundle:Photo:list.html.twig', ['photos'=>$photos]);
    }

    public function uploadAction(Request $request)
    {
        $photo = $this->container->get('zpb_photofactory')->createPhoto();

        $form = $this->createForm(new PhotoType(), $photo, ['em'=>$this->getManager()]);

        $form->handleRequest($request);

        if($form->isValid()){

            /*$this->getManager()->persist($photo);
            $this->getManager()->flush();*/

            return $this->redirect($this->generateUrl('zpb_admin_photos_list'));
        }

        return $this->render('ZPBAdminPhototekBundle:Photo:upload.html.twig', ['form'=>$form->createView()]);
    }

    public function editAction($id, Request $request)
    {
        $photo = $this->getRepo('ZPBAdminPhototekBundle:Photo')->find($id);
        if(!$photo){
            throw $this->createNotFoundException(); //TODO photo not found
        }
        $form = $this->createForm(new PhotoType(), $photo, ['em'=>$this->getManager()]);

        $form->handleRequest($request);

        if($form->isValid()){

            /*$this->getManager()->persist($photo);
            $this->getManager()->flush();*/

            return $this->redirect($this->generateUrl('zpb_admin_photos_list'));
        }
        return $this->render('ZPBAdminPhototekBundle:Photo:edit.html.twig', ['form'=>$form->createView()]);
    }

    public function deleteAction($id, Request $request)
    {
        $token = $request->query->get('_token', false);
        if(!$token || !$this->getCsrf()->isCsrfTokenValid('delete_photo', $token)){
            throw $this->createAccessDeniedException(); //TODO
        }
        $photo = $this->getRepo('ZPBAdminPhototekBundle:Photo')->find($id);
        if(!$photo){
            throw $this->createNotFoundException(); //TODO photo not found
        }
        /*$this->getManager()->remove($photo);
            $this->getManager()->flush();*/
        return $this->redirect($this->generateUrl('zpb_admin_photos_list'));

    }
} 
