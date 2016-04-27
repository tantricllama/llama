<?php
namespace Llama;

/**
 * Image class for use in Llama.
 *
 * @category Llama
 * @package  Image
 * @author   Brendan Smith <brendan.s@crazydomains.com>
 * @version  1.0
 */
class Image
{

    /**
     * Absolute path to the image file.
     *
     * @access private
     * @var    string
     */
    private $filepath;

    /**
     * The width of the image in pixels.
     *
     * @access private
     * @var    int
     */
    private $width;

    /**
     * The height of the image in pixels.
     *
     * @access private
     * @var    int
     */
    private $height;

    /**
     * IMAGETYPE_NNN constants indicating the type of the image.
     *
     * @access private
     * @var    int
     */
    private $type;

    /**
     * The image resource.
     *
     * @access private
     * @var    resource
     */
    private $image;

    /**
     * Constructor
     *
     * Set up the image object.
     *
     * @param string $filepath The path to an image file, this can be absolute or relative.
     *
     * @access public
     */
    public function __construct($filepath)
    {
        list($this->width, $this->height, $this->type) = getimagesize($filepath);

        $this->filepath = $filepath;
    }

    /**
     * Resize the image to a maximum width.
     *
     * @param int $maxWidth The maximum width the image can be after resizing.
     *
     * @access public
     * @return void
     */
    public function scaleToWidth($maxWidth)
    {
        $this->resizeByRatio(($maxWidth / $this->width));
    }

    /**
     * Resize the image to a maximum height.
     *
     * @param int $maxHeight The maximum height the image can be after resizing.
     *
     * @access public
     * @return void
     */
    public function scaleToHeight($maxHeight)
    {
        $this->resizeByRatio(($maxHeight / $this->height));
    }

    /**
     * Resize the image to a fit within the given width or height.
     *
     * @param int $maxWidth  The maximum width the image can be after resizing.
     * @param int $maxHeight The maximum height the image can be after resizing.
     *
     * @access public
     * @return void
     */
    public function scale($maxWidth, $maxHeight)
    {
        $this->resizeByRatio(min($maxWidth / $this->width, $maxHeight / $this->height));
    }

    /**
     * Rotate the image to the specified angle.
     *
     * @param int $angle The angle to rotate the image to.
     *
     * @access public
     * @return void
     */
    public function rotate($angle)
    {
        $this->image = imagerotate($this->getImageHandler(), 360 - $angle, 0);
    }

    /**
     * Save the image.
     *
     * @param string[optional] $filepath If the filepath is specified the image
     *                                   will be saved to this location,
     *                                   otherwise the image will be saved to
     *                                   it's original location.
     * @param int[optional]    $quality  The quality the image will be saved as.
     *
     * @access public
     * @return void
     */
    public function save($filepath = null, $quality = 100)
    {
        if (is_null($filepath)) {
            $filepath = $this->filepath;
        }

        imagejpeg($this->image, $filepath, $quality);
    }

    /**
     * Return the image resource.
     *
     * @access public
     * @return resource
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Resize the image to a given ratio.
     *
     * @param float $ratio The ratio to resize the image to.
     *
     * @access pivate
     * @return void
     */
    private function resizeByRatio($ratio)
    {
        $this->resize(round($this->width * $ratio), round($this->height * $ratio));
    }

    /**
     * Resize the image to a width and height.
     *
     * @param int $newWidth  The width to resize the image to.
     * @param int $newHeight The height to resize the image to.
     *
     * @access pivate
     * @return void
     */
    private function resize($newWidth, $newHeight)
    {
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled(
            $newImage,
            $this->getImageHandler(),
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $this->width,
            $this->height
        );

        $this->image = $newImage;
    }

    /**
     * Create and return an image handler resource based on the type of image.
     *
     * @access pivate
     * @return resource
     */
    private function getImageHandler()
    {
        switch ($this->type) {
            case IMAGETYPE_GIF:
                return imagecreatefromgif($this->filepath);
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($this->filepath);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($this->filepath);
        }
    }
}

