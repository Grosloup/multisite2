<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 08:53
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

namespace ZPB\Admin\CommonBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @param null $name
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function getManager($name = null)
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }
        return $this->get('doctrine')->getManager($name);
    }

    /**
     * @param $repo
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepo($repo)
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }
        if(!$repo){
            throw new \LogicException('You must provide a repository.');
        }

        return $this->get('doctrine')->getRepository($repo);
    }

    /**
     * @return \Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfTokenManagerAdapter
     */
    public function getCsrf()
    {
        if(!$this->container->has('form.csrf_provider')){
            throw new \LogicException('The form.csrf_provider is undefined in container');
        }
        return $this->get('form.csrf_provider');
    }

    /**
     * @param string $token
     * @param string $intention
     * @return bool
     */
    public function validateToken($token = '', $intention='')
    {
        if(!$token || !$this->getCsrf()->isCsrfTokenValid($intention, $token)){
            return false;
        }
        return true;
    }
}
