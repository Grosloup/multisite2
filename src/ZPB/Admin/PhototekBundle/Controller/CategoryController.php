<?php


namespace ZPB\Admin\PhototekBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ZPB\Admin\CommonBundle\Controller\BaseController;
use ZPB\Admin\PhototekBundle\Entity\PhotoCategory;

class CategoryController extends BaseController
{
    public function listAction($page = 1)
    {
        $categories = $this->getRepo('ZPBAdminPhototekBundle:PhotoCategory')->findAll(); //TODO pagination ?
        return $this->render('ZPBAdminPhototekBundle:Category:list.html.twig',['categories'=>$categories]);
    }

    public function newAction(Request $request)
    {
        $categorie = new PhotoCategory();

        return $this->render('ZPBAdminPhototekBundle:Category:list.html.twig',['form'=>'']);
    }

    public function editAction($id, Request $request)
    {
        $categorie = $this->getRepo('ZPBAdminPhototekBundle:PhotoCategory')->find($id);

        return $this->render('ZPBAdminPhototekBundle:Category:list.html.twig',['form'=>'']);
    }

    public function deleteAction($id, Request $request)
    {
        $categorie = $this->getRepo('ZPBAdminPhototekBundle:PhotoCategory')->find($id);

        return $this->redirect($this->generateUrl('zpb_admin_photos_categories_list'));
    }
} 
