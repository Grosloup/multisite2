<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 20:43
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

namespace ZPB\Admin\NewsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZPB\Admin\NewsBundle\Entity\PostTarget;

class LoadTargets extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $target1 = new PostTarget();
        $target1->setName('ZooParc de Beauval');
        $manager->persist($target1);
        $target2 = new PostTarget();
        $target2->setName('Les Jardins de Beauval');
        $manager->persist($target2);
        $target3 = new PostTarget();
        $target3->setName('Les Pagodes de Beauval');
        $manager->persist($target3);
        $target4 = new PostTarget();
        $target4->setName('Les Hameaux de Beauval');
        $manager->persist($target4);
        $manager->flush();

        $this->addReference('zpb-news-target-1',$target1);
        $this->addReference('zpb-news-target-2',$target2);
        $this->addReference('zpb-news-target-3',$target3);
        $this->addReference('zpb-news-target-4',$target4);
    }

    public function getOrder()
    {
        return 97;
    }
}
