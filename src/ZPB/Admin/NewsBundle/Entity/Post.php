<?php

namespace ZPB\Admin\NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use ZPB\Admin\NewsBundle\Validator\Constraints as ZPBAssert;
use ZPB\Admin\UserBundle\Entity\AdminUser;

/**
 * Post
 *
 * @ORM\Table(name="zpb_news_posts")
 * @ORM\Entity(repositoryClass="ZPB\Admin\NewsBundle\Entity\PostRepository")
 */
class Post
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
     * @var string
     *
     * @ORM\Column(name="long_id", type="string",length=255, nullable=false, unique=true)
     */
    private $longId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255, unique=true, nullable=true)
     * @Gedmo\Slug(fields={"title"}, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="excerpt", type="text", nullable=true)
     */
    private $excerpt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var string
     * @ZPBAssert\PostTypes()
     * @ORM\Column(name="post_type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="archived_at", type="datetime", nullable=true)
     */
    private $archivedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dropped_at", type="datetime", nullable=true)
     */
    private $droppedAt;

    /**
     * @var array
     * @Assert\Type(type="array", message="'A la une' n'est pas du bon type (tableau).")
     */
    private $fronts;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_draft", type="boolean")
     */
    private $isDraft;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_published", type="boolean")
     */
    private $isPublished;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_archive", type="boolean")
     */
    private $isArchive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_dropped", type="boolean")
     */
    private $isDropped;

    /**
     * @var integer
     * @ORM\Column(name="view_counter", type="integer", nullable=true)
     */
    private $viewCounter;

    /**
     * @ORM\ManyToOne(targetEntity="ZPB\Admin\UserBundle\Entity\AdminUser")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=true)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="ZPB\Admin\NewsBundle\Entity\PostCategory", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="ZPB\Admin\NewsBundle\Entity\PostTag", inversedBy="posts")
     * @ORM\JoinTable(name="zpb_news_posts_tags")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity="ZPB\Admin\NewsBundle\Entity\PostTarget", inversedBy="posts")
     * @ORM\JoinTable(name="zpb_news_posts_targets")
     */
    private $targets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->targets = new ArrayCollection();
        $this->fronts = [];
        $this->setIsDraft(true);
        $this->setIsPublished(false);
        $this->setIsDropped(false);
        $this->setIsArchive(false);
        $this->setViewCounter(0);
        $longId = md5((new \DateTime('now', new \DateTimeZone('Europe/Paris')))->getTimestamp() . uniqid(mt_rand(), true));
        $this->longId = substr($longId, 0, 8);
    }

    /**
     * @return string
     */
    public function getLongId()
    {
        return $this->longId;
    }

    /**
     * @param string $longId
     * @return Post
     */
    public function setLongId($longId)
    {
        $this->longId = $longId;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsArchive()
    {
        return $this->isArchive;
    }

    /**
     * @param boolean $isArchive
     * @return Post
     */
    public function setIsArchive($isArchive)
    {
        $this->isArchive = $isArchive;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getArchivedAt()
    {
        return $this->archivedAt;
    }

    /**
     * @param \DateTime $archivedAt
     * @return Post
     */
    public function setArchivedAt($archivedAt)
    {
        $this->archivedAt = $archivedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Post
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set excerpt
     *
     * @param string $excerpt
     * @return Post
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


    /**
     * Get publishedAt
     *
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     * @return Post
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get droppedAt
     *
     * @return \DateTime
     */
    public function getDroppedAt()
    {
        return $this->droppedAt;
    }

    /**
     * Set droppedAt
     *
     * @param \DateTime $droppedAt
     * @return Post
     */
    public function setDroppedAt($droppedAt)
    {
        $this->droppedAt = $droppedAt;

        return $this;
    }

    /**
     * Get fronts
     *
     * @return array
     */
    public function getFronts()
    {
        return $this->fronts;
    }

    /**
     * Set isFront
     *
     * @param array $fronts
     * @return Post
     */
    public function setFronts($fronts)
    {
        if(!$this->fronts){
            $this->fronts = $fronts;
        } else {
            $this->fronts = array_unique(array_merge($this->fronts, $fronts));
        }


        return $this;
    }

    /**
     * Get isDraft
     *
     * @return boolean
     */
    public function getIsDraft()
    {
        return $this->isDraft;
    }

    /**
     * Set isDraft
     *
     * @param boolean $isDraft
     * @return Post
     */
    public function setIsDraft($isDraft)
    {
        $this->isDraft = $isDraft;

        return $this;
    }

    /**
     * Get isPublished
     *
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set isPublished
     *
     * @param boolean $isPublished
     * @return Post
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Get isDropped
     *
     * @return boolean
     */
    public function getIsDropped()
    {
        return $this->isDropped;
    }

    /**
     * Set isDropped
     *
     * @param boolean $isDropped
     * @return Post
     */
    public function setIsDropped($isDropped)
    {
        $this->isDropped = $isDropped;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get viewCounter
     *
     * @return integer
     */
    public function getViewCounter()
    {
        return $this->viewCounter;
    }

    /**
     * Set viewCounter
     *
     * @param integer $viewCounter
     * @return Post
     */
    public function setViewCounter($viewCounter)
    {
        $this->viewCounter = $viewCounter;

        return $this;
    }

    /**
     * Get owner
     *
     * @return AdminUser
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set owner
     *
     * @param AdminUser $owner
     * @return Post
     */
    public function setOwner(AdminUser $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get category
     *
     * @return PostCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param PostCategory $category
     * @return Post
     */
    public function setCategory(PostCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Add tags
     *
     * @param PostTag $tags
     * @return Post
     */
    public function addTag(PostTag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param PostTag $tags
     */
    public function removeTag(PostTag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add targets
     *
     * @param PostTarget $targets
     * @return Post
     */
    public function addTarget(PostTarget $targets)
    {
        $this->targets[] = $targets;

        return $this;
    }

    /**
     * Remove targets
     *
     * @param PostTarget $targets
     */
    public function removeTarget(PostTarget $targets)
    {
        $this->targets->removeElement($targets);
    }

    /**
     * Get targets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTargets()
    {
        return $this->targets;
    }
}
