<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 22/08/2014
 * Time: 18:27
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

namespace ZPB\Admin\MediatekBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use ZPB\Admin\CommonBundle\Controller\BaseController;
use ZPB\Admin\MediatekBundle\Form\Type\ImageUploadType;

class ImagesController extends BaseController
{
    public function listAction($page = 1)
    {
        $images = $this->getRepo('ZPBAdminMediatekBundle:Image')->findAll();

        return $this->render('ZPBAdminMediatekBundle:Images:list.html.twig', ['images'=>$images, 'page'=>$page]);
    }

    public function uploadAction(Request $request)
    {
        $image = $this->get('zpb_imagefactory')->createImage();

        $form = $this->createForm(new ImageUploadType(), $image);
        $form->handleRequest($request);

        if($form->isValid()){
            $image->upload();
            $this->container->get('zpb_thumbfactory')->resize($image);
            $this->getManager()->persist($image);
            $this->getManager()->flush();
            return $this->redirect($this->generateUrl('zpb_admin_mediatek_image_list'));
        }
        return $this->render('ZPBAdminMediatekBundle:Images:upload.html.twig', ['form'=>$form->createView()]);
    }

    public function editAction($id, Request $request)
    {
        $image = $this->getRepo('ZPBAdminMediatekBundle:Image')->find($id);
        if(!$image){
            throw $this->createNotFoundException();
        }
    }

    public function deleteAction($id, Request $request)
    {
        $token = $request->query->get('_token', false);
        if(!$token || !$this->getCsrf()->isCsrfTokenValid('delete_image', $token)){
            throw $this->createAccessDeniedException();
        }
        $image = $this->getRepo('ZPBAdminMediatekBundle:Image')->find($id);
        if(!$image){
            throw $this->createNotFoundException();
        }
        $page = $request->query->get('_page', 1);
        $this->getManager()->remove($image);
        $this->getManager()->flush();
        return $this->redirect($this->generateUrl('zpb_admin_mediatek_image_list', ['page'=>$page]));
    }

}
