<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 20:10
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
use ZPB\Admin\NewsBundle\Entity\PostCategory;

class LoadCategories extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $cat1 = new PostCategory();
        $cat1->setName('Généralités ');
        $manager->persist($cat1);

        $cat2 = new PostCategory();
        $cat2->setName('Nouveauté');
        $manager->persist($cat2);

        $cat3 = new PostCategory();
        $cat3->setName('Carnet rose');
        $manager->persist($cat3);

        $manager->flush();

        $this->addReference('zpb-news-cat-1',$cat1);
        $this->addReference('zpb-news-cat-2',$cat2);
        $this->addReference('zpb-news-cat-3',$cat3);
    }

    public function getOrder()
    {
        return 95;
    }
}
