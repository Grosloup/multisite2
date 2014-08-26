<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 26/08/14
 * Time: 09:09
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

namespace ZPB\Admin\UserBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use ZPB\Admin\CommonBundle\Controller\BaseController;
use ZPB\Admin\UserBundle\Entity\Role;
use ZPB\Admin\UserBundle\Form\Type\RoleEditType;
use ZPB\Admin\UserBundle\Form\Type\RoleType;

class RoleController extends BaseController
{
    public function listAction()
    {
        $roles = $this->getRepo('ZPBAdminUserBundle:Role')->findAll();

        return $this->render('ZPBAdminUserBundle:Role:list.html.twig', ['roles'=>$roles]);
    }

    public function createAction(Request $request)
    {
        $role = new Role();
        $form = $this->createForm(new RoleType(), $role);

        $form->handleRequest($request);
        if($form->isValid()){

            /*$em = $this->getManager();
            $em->persist($role);
            $em->flush();*/
        }

        return $this->render('ZPBAdminUserBundle:Role:create.html.twig', ['form'=>$form->createView()]);
    }

    public function editAction($id, Request $request)
    {
        $role = $this->getRepo('ZPBAdminUserBundle:Role')->find($id);

        if(!$role){
            throw $this->createNotFoundException(); //TODO Role not found
        }
        $form = $this->createForm(new RoleEditType(), $role);

        $form->handleRequest($request);
        if($form->isValid()){

            /*$em = $this->getManager();
            $em->persist($role);
            $em->flush();*/
        }
        return $this->render('ZPBAdminUserBundle:Role:edit.html.twig', ['form'=>$form->createView(), 'role'=>$role]);
    }

    public function deleteAction($id, Request $request)
    {
        $token = $request->query->get('_token', false);
        if(!$token || !$this->getCsrf()->isCsrfTokenValid('delete_role', $token)){
            throw $this->createAccessDeniedException();
        }
        $role = $this->getRepo('ZPBAdminUserBundle:Role')->find($id);

        if(!$role){
            throw $this->createNotFoundException(); //TODO Role not found
        }

        /*$em = $this->getManager();
        $em->remove($role);
        $em->flush();*/

        return $this->redirect($this->generateUrl('zpb_admin_roles_list'));
    }
} 
