<?php

namespace ZPB\Admin\PhototekBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Photo
 *
 * @ORM\Table(name="zpb_phototek_photos")
 * @ORM\Entity(repositoryClass="ZPB\Admin\PhototekBundle\Entity\PhotoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Photo
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
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public $file;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer")
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer")
     */
    private $height;

    /**
     * @ORM\Column(name="title", type="text", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(name="copyright", type="string", length=255, nullable=false)
     */
    private $copyright;

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
     *
     * @ORM\Column(name="rootDir", type="string", length=255, nullable=false)
     */
    private $rootDir;

    /**
     * @var string
     *
     * @ORM\Column(name="uploadDir", type="string", length=255, nullable=false)
     */
    private $uploadDir;

    /**
     * @var string
     *
     * @ORM\Column(name="thumb_dir", type="string", length=255, nullable=false)
     */
    private $thumbDir;

    /**
     * @var string
     *
     * @ORM\Column(name="mime", type="string", length=50, nullable=false)
     */
    private $mime;

    /**
     * @ORM\ManyToMany(targetEntity="ZPB\Admin\PhototekBundle\Entity\PhotoTag", inversedBy="photos")
     * @ORM\JoinTable(name="zpb_photos_tags")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="ZPB\Admin\PhototekBundle\Entity\PhotoCategory", inversedBy="photos")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    private $preRemoveAbsPath;

    private $preRemoveThumbAbsPath;

    /**
     * Constructor
     */
    public function __construct($rootDir = '', $uploadDir = '', $thumbDir='')
    {
        $this->tags = new ArrayCollection();
        $this->rootDir = $rootDir;
        $this->uploadDir = $uploadDir;
        $this->thumbDir = $thumbDir;
    }

    public function upload()
    {
        if(!$this->file){
            return false;
        }
        $this->extension = $this->file->guessExtension();
        $this->mime = $this->file->getMimeType();
        $dest = $this->rootDir . $this->uploadDir;
        if(!$this->filename){
            $this->filename = $this->sanitizeFilename($this->file->getClientOriginalName());
        }
        $this->file->move($dest, $this->filename . '.' . $this->extension);
        $size = getimagesize($this->getAbsolutePath());
        $this->width = $size[0];
        $this->height = $size[1];
        $this->file = null;
        return true;
    }

    public function getAbsPath()
    {
        return $this->rootDir . $this->uploadDir . $this->filename . '.' . $this->extension;
    }

    public function getWebPath()
    {
        return '/' . $this->uploadDir . $this->filename . '.' . $this->extension;
    }

    public function getThumbAbsPath()
    {
        return $this->rootDir . $this->thumbDir . $this->filename . '.' . $this->extension;
    }

    public function getThumbWebPath()
    {
        return '/' . $this->thumbDir . $this->filename . '.' . $this->extension;
    }

    private function sanitizeFilename($string="")
    {
        return preg_replace('/[^a-zA-Z0-9._-]/', '', $string);
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemove()
    {
        $this->preRemoveAbsPath = $this->getAbsPath();
        $this->preRemoveThumbAbsPath = $this->getThumbAbsPath();
    }
    /**
     * @ORM\PostRemove()
     */
    public function postRemove()
    {
        if($this->preRemoveAbsPath != null && file_exists($this->preRemoveAbsPath)){
            unlink($this->preRemoveAbsPath);
        }
        if($this->preRemoveThumbAbsPath != null && file_exists($this->preRemoveThumbAbsPath)){
            unlink($this->preRemoveThumbAbsPath);
        }
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
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Photo
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Photo
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return Photo
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Photo
     */
    public function setHeight($height)
    {
        $this->height = $height;

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
     * @return Photo
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Photo
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get rootDir
     *
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * Set rootDir
     *
     * @param string $rootDir
     * @return Photo
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = rtrim($rootDir, ' /') . '/';

        return $this;
    }

    /**
     * Get uploadDir
     *
     * @return string
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    /**
     * Set uploadDir
     *
     * @param string $uploadDir
     * @return Photo
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = rtrim($uploadDir, ' /');

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * @param mixed $copyright
     * @return Photo
     */
    public function setCopyright($copyright)
    {
        $copyright = trim($copyright);
        if($copyright[0] != '@'){
            $copyright = '@ ' . $copyright;
        }
        $this->copyright = $copyright;
        return $this;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @param string $mime
     * @return Photo
     */
    public function setMime($mime)
    {
        $this->mime = $mime;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbDir()
    {
        return $this->thumbDir;
    }

    /**
     * @param string $thumbDir
     * @return Photo
     */
    public function setThumbDir($thumbDir)
    {
        $this->thumbDir = rtrim($thumbDir, ' /');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Photo
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Add tags
     *
     * @param PhotoTag $tags
     * @return Photo
     */
    public function addTag(PhotoTag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param PhotoTag $tags
     */
    public function removeTag(PhotoTag $tags)
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
     * Get category
     *
     * @return PhotoCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param PhotoCategory $category
     * @return Photo
     */
    public function setCategory(PhotoCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }
}
