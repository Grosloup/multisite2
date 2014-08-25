<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 20:24
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
use ZPB\Admin\NewsBundle\Entity\PostTag;

class LoadTags extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $tag1 = new PostTag();
        $tag1->setName('éléphant');
        $manager->persist($tag1);

        $tag2 = new PostTag();
        $tag2->setName('lion');
        $manager->persist($tag2);

        $tag3 = new PostTag();
        $tag3->setName('rhino');
        $manager->persist($tag3);

        $tag4 = new PostTag();
        $tag4->setName('gorille');
        $manager->persist($tag4);



        $manager->flush();

        $this->addReference('zpb-news-tag-1',$tag1);
        $this->addReference('zpb-news-tag-2',$tag2);
        $this->addReference('zpb-news-tag-3',$tag3);
        $this->addReference('zpb-news-tag-4',$tag4);
    }

    public function getOrder()
    {
        return 96;
    }
}
