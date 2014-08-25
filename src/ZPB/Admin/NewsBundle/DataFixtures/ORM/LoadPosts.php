<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/08/2014
 * Time: 19:45
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
use ZPB\Admin\NewsBundle\Entity\Post;

class LoadPosts extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container=null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $post1 = new Post();
        $post1
            ->setTitle('Article 1')->setType('post')
            ->setBody('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem consequuntur cupiditate illum in iusto magni nihil quo quos ullam voluptatum.</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore enim error facilis, itaque nam quia. Assumenda cum, cumque, facere, inventore ipsum iste itaque sapiente similique sint sunt totam velit vitae!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda debitis eligendi eum ipsa ullam. Ad amet asperiores, assumenda beatae deleniti dicta distinctio exercitationem, fugiat, illo illum in laboriosam omnis perspiciatis quam quia quibusdam sed velit. Ab adipisci asperiores distinctio enim libero quod sequi sint totam voluptates. Eligendi quae quos ullam!</p>')
            ->setExcerpt('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio dolor expedita maiores nam quasi quia quod voluptatum. Distinctio explicabo harum molestiae odio pariatur! A debitis, illum possimus tempora vero voluptatem.</p>')
        ;

        $manager->persist($post1);
        $manager->getRepository('ZPBAdminNewsBundle:Post')->solveFronts($post1,$manager);
        $post2 = new Post();
        $post2
            ->setTitle('Article 2')->setType('post')
            ->setBody('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad atque aut consequuntur dolore earum explicabo, fuga illo labore magnam molestiae officiis reprehenderit rerum tempora. Ab at dignissimos dolore doloremque, esse eveniet, in nesciunt optio porro possimus repellat saepe tempore. Ab animi autem eaque et incidunt itaque laboriosam nihil quidem sequi!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad assumenda consectetur molestiae qui quia veniam voluptatem. Aliquam magni minima optio quas repellendus. A beatae commodi deleniti doloribus eius, enim eos et eveniet facere fuga harum id in incidunt mollitia nam nihil omnis praesentium quas quasi sapiente suscipit temporibus veritatis voluptatum. Aliquam aliquid doloremque ducimus illum nesciunt quas sequi tempore unde.</p>')
            ->setExcerpt('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aspernatur atque dignissimos id labore nesciunt omnis quaerat ratione reiciendis vel, vitae voluptatum. Aliquam aspernatur delectus eligendi libero magni pariatur totam.</p>')
        ;

        $post2->setCategory($this->getReference('zpb-news-cat-1'));
        $post2->addTarget($this->getReference('zpb-news-target-1'));
        $post2->addTarget($this->getReference('zpb-news-target-2'));
        $post2->setFronts([$this->getReference('zpb-news-target-1')->getId()]);
        $this->getReference('zpb-news-cat-1')->addPost($post2);
        $this->getReference('zpb-news-target-1')->addPost($post2);
        $this->getReference('zpb-news-target-2')->addPost($post2);


        $manager->persist($this->getReference('zpb-news-cat-1'));
        $manager->getRepository('ZPBAdminNewsBundle:Post')->publish($post2);
        $manager->persist($post2);
        $manager->getRepository('ZPBAdminNewsBundle:Post')->solveFronts($post2,$manager);
        $post3 = new Post();
        $post3
            ->setTitle('Article 3')->setType('flash_news')
            ->setBody('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad atque aut consequuntur dolore earum explicabo, fuga illo labore magnam molestiae officiis reprehenderit rerum tempora. Ab at dignissimos dolore doloremque, esse eveniet, in nesciunt optio porro possimus repellat saepe tempore. Ab animi autem eaque et incidunt itaque laboriosam nihil quidem sequi!</p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad assumenda consectetur molestiae qui quia veniam voluptatem. Aliquam magni minima optio quas repellendus. A beatae commodi deleniti doloribus eius, enim eos et eveniet facere fuga harum id in incidunt mollitia nam nihil omnis praesentium quas quasi sapiente suscipit temporibus veritatis voluptatum. Aliquam aliquid doloremque ducimus illum nesciunt quas sequi tempore unde.</p>')
            ->setExcerpt('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aspernatur atque dignissimos id labore nesciunt omnis quaerat ratione reiciendis vel, vitae voluptatum. Aliquam aspernatur delectus eligendi libero magni pariatur totam.</p>')
        ;
        $post3->addTarget($this->getReference('zpb-news-target-1'));
        $post3->addTarget($this->getReference('zpb-news-target-3'));
        $post3->addTarget($this->getReference('zpb-news-target-4'));

        $post3->setFronts([$this->getReference('zpb-news-target-1')->getId(), $this->getReference('zpb-news-target-4')->getId()]);

        $this->getReference('zpb-news-target-1')->addPost($post3);
        $this->getReference('zpb-news-target-3')->addPost($post3);
        $this->getReference('zpb-news-target-4')->addPost($post3);

        $post3->setCategory($this->getReference('zpb-news-cat-2'));
        $this->getReference('zpb-news-cat-2')->addPost($post3);
        $post3->addTag($this->getReference('zpb-news-tag-1'));
        $post3->addTag($this->getReference('zpb-news-tag-2'));
        $this->getReference('zpb-news-tag-1')->addPost($post3);
        $this->getReference('zpb-news-tag-2')->addPost($post3);

        $manager->persist($this->getReference('zpb-news-cat-2'));
        $manager->persist( $this->getReference('zpb-news-tag-1'));
        $manager->persist( $this->getReference('zpb-news-tag-2'));
        $manager->getRepository('ZPBAdminNewsBundle:Post')->publish($post3);
        $manager->persist($post3);
        $manager->getRepository('ZPBAdminNewsBundle:Post')->solveFronts($post3,$manager);
        $manager->persist($this->getReference('zpb-news-target-1'));
        $manager->persist($this->getReference('zpb-news-target-2'));
        $manager->persist($this->getReference('zpb-news-target-3'));
        $manager->persist($this->getReference('zpb-news-target-4'));


        $manager->flush();



        $this->addReference('zpb-news-post-1',$post1);
        $this->addReference('zpb-news-post-2',$post2);
        $this->addReference('zpb-news-post-3',$post3);
    }

    public function getOrder()
    {
        return 100;
    }
}
