<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 26/08/14
 * Time: 14:37
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

namespace ZPB\Admin\MediatekBundle\Service;


use Symfony\Component\Filesystem\Filesystem;
use ZPB\Admin\MediatekBundle\Entity\Image;

class ThumbMaker
{
    private $filesystem;
    private $maxSize = 100;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @return mixed
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @param mixed $maxSize
     */
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;
    }

    public function resize(Image $image)
    {
        if (!$image) {
            return null;
        }

        if ($image->getAbsolutePath() == null || $image->getAbsoluteThumbnailPath() == null) {
            return null;
        }

        if ($image->getWidth() >= $image->getHeight()) {
            $this->landscape($image);
        }

        if ($image->getWidth() < $image->getHeight()) {
            $this->portrait($image);
        }
    }

    private function landscape(Image $image)
    {
        $filename = $image->getAbsolutePath();
        $img = $this->createImage($filename, $image->getMime());
        $destFilename = $image->getAbsoluteThumbnailPath();
        if ($image->getWidth() > $this->maxSize) {
            $ratio = $this->maxSize / $image->getWidth();
            $newHeight = $image->getHeight() * $ratio;
            $redim = imagecreatetruecolor($this->maxSize, $newHeight);
            imagecopyresampled($redim, $img, 0, 0, 0, 0, $this->maxSize, $newHeight, $image->getWidth(), $image->getHeight());
            $this->save($redim, $destFilename, $image->getMime());
            imagedestroy($redim);
        } else {
            $this->filesystem->copy($filename, $destFilename, true);
        }
    }

    private function portrait(Image $image)
    {
        $filename = $image->getAbsolutePath();
        $img = $this->createImage($filename, $image->getMime());
        $destFilename = $image->getAbsoluteThumbnail();
        if ($image->getHeight() > $this->maxSize) {
            $ratio = $this->maxSize / $image->getHeight();
            $newWidth = $ratio * $image->getWidth();
            $redim = imagecreatetruecolor($newWidth, $this->maxSize);
            imagecopyresampled($redim, $img, 0, 0, 0, 0, $newWidth, $this->maxSize, $image->getWidth(), $image->getHeight());
            $this->save($redim, $destFilename, $image->getMime());
            imagedestroy($redim);
        } else {
            $this->filesystem->copy($filename, $destFilename, true);
        }
    }

    private function createImage($file, $mime = 'image/jpeg')
    {
        $img = null;
        switch ($mime) {
            case 'image/png':
                $img = imagecreatefrompng($file);
                break;
            case 'image/gif':
                $img = imagecreatefromgif($file);
                break;
            case 'image/jpeg':
                $img = imagecreatefromjpeg($file);
                break;
        }
        return $img;
    }

    private function save($img, $filename, $mime = 'image/jpeg', $quality = 75)
    {
        switch ($mime) {
            case 'image/png':
                imagepng($img, $filename);
                break;
            case 'image/gif':
                imagegif($img, $filename);
                break;
            case 'image/jpeg':
                imagejpeg($img, $filename, $quality);
                break;
        }
    }
} 
