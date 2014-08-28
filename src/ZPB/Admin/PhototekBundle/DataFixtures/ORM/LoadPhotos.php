<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/08/14
 * Time: 10:30
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

namespace ZPB\Admin\PhototekBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

class LoadPhotos extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $fs = $this->container->get('filesystem');
        $finder = new Finder();

        $finder->files()->in($this->container->getParameter('zpb_phototek_root_dir'). $this->container->getParameter('zpb_phototek_upload_dir'))->ignoreDotFiles(true);
        foreach($finder as $file){
            /** @var \SplFileInfo $file */
            $fs->remove($file->getRealPath());
        }
        $finder->files()->in($this->container->getParameter('zpb_phototek_root_dir').$this->container->getParameter('zpb_phototek_upload_thumb_dir'))->ignoreDotFiles(true);
        foreach($finder as $file){
            /** @var \SplFileInfo $file */
            $fs->remove($file->getRealPath());
        }

        $fs->copy($this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/image1.jpg",$this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/tmp/image1.jpg");
        $fs->copy($this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/image2.jpg",$this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/tmp/image2.jpg");
        $fs->copy($this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/image3.jpg",$this->container->getParameter('zpb_mediatek_root_dir') . "fixtures/images/tmp/image3.jpg");

        $photoFactory =  $this->container->get('zpb_photofactory');

        //TODO ThumbMaker etc...

    }
    
    public function getOrder()
    {
        return 65;
    }
}
