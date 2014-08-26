<?php

namespace ZPB\Admin\MediatekBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ZPB\Admin\MediatekBundle\Validator\Constraints as ZPBAssert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Image
 *
 * @ORM\Table(name="zpb_admin_images")
 * @ORM\Entity(repositoryClass="ZPB\Admin\MediatekBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create')
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
     * @Assert\Regex("/^[a-zA-Z0-9._-]*$/", message="Ce champ contient des caractères non autorisés.")
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=5, nullable=false)
     * @ZPBAssert\ImageExtension()
     */
    private $extension;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=false)
     * @Assert\Regex("/^[0-9]+$/", message="Ce champs n'est pas du bon type")
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=false)
     * @Assert\Regex("/^[0-9]+$/", message="Ce champs n'est pas du bon type")
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="copyright", type="string", length=255, nullable=false)
     */
    private $copyright;

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
     * @ORM\Column(name="thumbDir", type="string", length=255, nullable=false)
     */
    private $thumbDir;

    /**
     * @var string
     *
     * @ORM\Column(name="mime", type="string", length=100, nullable=false)
     */
    private $mime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_post_thumbnail", type="boolean")
     */
    private $isPostThumbnail;

    /**
     * @ORM\ManyToMany(targetEntity="ZPB\Admin\MediatekBundle\Entity\ImageTag", inversedBy="images")
     * @ORM\JoinTable(name="zpb_admin_imgs_tags")
     */
    private $tags;

    /**
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * @Assert\Image(maxSize="6291456",mimeTypes ={"image/png","image/jpeg","image/gif"}, mimeTypesMessage="Votre image n'est pas une image valide.", maxSizeMessage="Votre image est trop lourde.")
     */
    public $file;

    private $originalPathForRemove;

    private $thumbPathForRemove;

    /**
     * Constructor
     */
    public function __construct($uploadDir = 'uploads/images/', $thumbDir = 'uploads/admin/thumbs/', $rootDir = "web/", $copyright = "@ ZooParc de Beauval")
    {
        $this->tags = new ArrayCollection();
        $this->setUploadDir($uploadDir);
        $this->setThumbDir($thumbDir);
        $this->setRootDir($rootDir);
        $this->setCopyright($copyright);
        $this->isPostThumbnail = false;
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->file == null) {
            return false;
        }
        $this->extension = $this->file->getExtension();
        $this->mime = $this->file->getMimeType();

        $dest = $this->rootDir . $this->uploadDir;


        if(!$this->filename){
            $this->filename = $this->sanitizeFilename($this->file->getClientOriginalName());
        } else {
            $this->filename .= "." . $this->extension;
        }
        $this->file->move($dest, $this->filename);

        $size = getimagesize($this->getAbsolutePath());
        $this->width = $size[0];
        $this->height = $size[1];
        $this->file = null;

        return true;
    }

    public function getAbsolutePath()
    {
        return $this->rootDir . $this->uploadDir . $this->filename;
    }

    public function getAbsoluteThumbnailPath()
    {
        return $this->rootDir . $this->thumbDir . $this->filename;
    }

    public function getWebPath()
    {
        return "/" . $this->uploadDir . $this->filename;
    }

    /**
     * @param string $string
     * @return string
     */
    private function sanitizeFilename($string="")
    {
        return preg_replace('/[^a-zA-Z0-9._-]/', '', $string);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storePath()
    {
        $this->originalPathForRemove = $this->getAbsolutePath();
        $this->thumbPathForRemove = $this->getAbsoluteThumbnailPath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function remove()
    {
        if($this->originalPathForRemove != null){
            unlink($this->originalPathForRemove);
        }
        if($this->thumbPathForRemove != null){
            unlink($this->thumbPathForRemove);
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
     * @return Image
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
     * @return Image
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
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
     * @return Image
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
     * @return Image
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
     * @return Image
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
     * @return Image
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
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
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get copyright
     *
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * Set copyright
     *
     * @param string $copyright
     * @return Image
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
     * @return Image
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = trim($rootDir, " /") . "/";

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
     * @return Image
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = trim($uploadDir, " /") . "/";

        return $this;
    }

    /**
     * @param string $thumbDir
     * @return Image
     */
    public function setThumbDir($thumbDir)
    {
        $this->thumbDir = trim($thumbDir, " /") . "/";
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
     * Get mime
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Set mime
     *
     * @param string $mime
     * @return Image
     */
    public function setMime($mime)
    {
        $this->mime = $mime;

        return $this;
    }

    /**
     * Get isPostThumbnail
     *
     * @return boolean
     */
    public function getIsPostThumbnail()
    {
        return $this->isPostThumbnail;
    }

    /**
     * Set isPostThumbnail
     *
     * @param boolean $isPostThumbnail
     * @return Image
     */
    public function setIsPostThumbnail($isPostThumbnail)
    {
        $this->isPostThumbnail = $isPostThumbnail;

        return $this;
    }

    /**
     * Add tags
     *
     * @param ImageTag $tags
     * @return Image
     */
    public function addTag(ImageTag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param ImageTag $tags
     */
    public function removeTag(ImageTag $tags)
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
}
