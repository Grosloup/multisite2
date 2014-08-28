<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/08/14
 * Time: 15:30
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

namespace ZPB\Admin\PhototekBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use ZPB\Admin\PhototekBundle\Entity\Photo;

class PhotoFactory
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createPhoto()
    {
        $photo = new Photo();
        $photo
            ->setRootDir($this->container->getParameter('zpb_phototek_root_dir'))
            ->setThumbDir($this->container->getParameter('zpb_phototek_upload_dir'))
            ->setThumbDir($this->container->getParameter('zpb_phototek_upload_thumb_dir'))
        ;
        return $photo;
    }
} 
