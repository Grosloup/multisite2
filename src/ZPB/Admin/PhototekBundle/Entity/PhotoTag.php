<?php

namespace ZPB\Admin\PhototekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotoTag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ZPB\Admin\PhototekBundle\Entity\PhotoTagRepository")
 */
class PhotoTag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
