<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 26/08/14
 * Time: 14:37
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

class ThumbMaker
{
    private  $container;
    private $maxSize = 100;

    public function __construct(ContainerInterface $container)
    {
        $this->container  = $container;
    }

    /**
     * @return mixed
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @param mixed $maxSize
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function resize(Image $image)
    {
        if (!$image) {
            return null;
        }

        if ($image->getAbsolutePath() == null || $image->getAbsoluteThumbnailPath() == null) {
            return null;
        }

        if ($image->getWidth() >= $image->getHeight()) {
            $this->landscape($image);
        }

        if ($image->getWidth() < $image->getHeight()) {
            $this->portrait($image);
        }
    }

    private function landscape(Image $image){

    }

    private function portrait(Image $image)
    {

    }
} 
