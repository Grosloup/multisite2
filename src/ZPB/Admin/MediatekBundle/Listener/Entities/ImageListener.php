<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 27/08/14
 * Time: 14:44
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

namespace ZPB\Admin\MediatekBundle\Listener\Entities;


use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Filesystem\Filesystem;
use ZPB\Admin\MediatekBundle\Entity\Image;

class ImageListener
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if($entity instanceof Image){
            if($args->hasChangedField('filename')){
                $old = $args->getOldValue('filename') . "." . $entity->getExtension();
                $new = $args->getNewValue('filename') . "." . $entity->getExtension();

                $this->filesystem->rename($entity->getRootDir() . $entity->getUploadDir() . $old, $entity->getRootDir() . $entity->getUploadDir() . $new);
                $this->filesystem->rename($entity->getRootDir() . $entity->getThumbDir() . $old, $entity->getRootDir() . $entity->getThumbDir() . $new);
            }
            $entity->generateLongId();
        }
    }
} 
