<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 26/08/14
 * Time: 15:40
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

namespace ZPB\Admin\MediatekBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface;
use ZPB\Admin\MediatekBundle\Entity\Image;

class ImageFactory
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return Image
     */
    public function createImage()
    {
        $image = new Image();
        $image->setRootDir($this->container->getParameter('zpb_mediatek_root_dir'));
        $image->setUploadDir($this->container->getParameter('zpb_mediatek_img_uplaod_dir'));
        $image->setThumbDir($this->container->getParameter('zpb_mediatek_admin_img_thumbnail_dir'));
        $image->setCopyright($this->container->getParameter('zpb_mediatek_admin_img_copyright'));
        return $image;
    }
} 
