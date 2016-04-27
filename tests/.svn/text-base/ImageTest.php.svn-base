<?php
use Llama\Image;

/**
 * Image test case.
 */
class ImageTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Image
     */
    private $imageGif;

    /**
     * @var Image
     */
    private $imageJpg;

    /**
     * @var Image
     */
    private $imagePng;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        /**
         * image_test_original.gif is 150x100 standard GIF file the with .gif extension.
         */
        $this->imageGif = new Image(realpath(TESTS_PATH . '/_resources/image_test_original.gif'));

        /**
         * image_test_original.jpg is 150x100 standard JPEG file the with .jpg extension.
         */
        $this->imageJpg = new Image(realpath(TESTS_PATH . '/_resources/image_test_original.jpg'));

        /**
         * image_test_original.png is 150x100 standard PNG file the with .png extension.
         */
        $this->imagePng = new Image(realpath(TESTS_PATH . '/_resources/image_test_original.png'));
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->imageGif = null;
        $this->imageJpg = null;
        $this->imagePng = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        $extensions = array('gif', 'jpg', 'png');

        foreach ($extensions as $ext) {
            $source = realpath(TESTS_PATH . '/_resources/image_test.' . $ext);
            $destination = realpath(TESTS_PATH . '/_resources') . DIRECTORY_SEPARATOR . 'image_test_original.' . $ext;

            copy($source, $destination);
        }
    }

    /**
     * Destructs the test case.
     */
    public function __destruct()
    {
        $images = array('image_test_original', 'image_test_saved');
        $extensions = array('gif', 'jpg', 'png');

        foreach ($images as $image) {
            foreach ($extensions as $ext) {
                $filepath = realpath(TESTS_PATH . "/_resources/$image.$ext");

                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
        }
    }

    /**
     * Tests Image->__construct()
     */
    public function testMagicConstruct()
    {

        //gif
        $this->assertAttributeEquals(150, 'width', $this->imageGif);
        $this->assertAttributeEquals(100, 'height', $this->imageGif);
        $this->assertAttributeEquals(IMAGETYPE_GIF, 'type', $this->imageGif);
        $this->assertAttributeEquals(
            realpath(
                TESTS_PATH . '/_resources/image_test_original.gif'
            ),
            'filepath',
            $this->imageGif
        );

        //jpg
        $this->assertAttributeEquals(150, 'width', $this->imageJpg);
        $this->assertAttributeEquals(100, 'height', $this->imageJpg);
        $this->assertAttributeEquals(IMAGETYPE_JPEG, 'type', $this->imageJpg);
        $this->assertAttributeEquals(
            realpath(
                TESTS_PATH . '/_resources/image_test_original.jpg'
            ),
            'filepath',
            $this->imageJpg
        );

        //png
        $this->assertAttributeEquals(150, 'width', $this->imagePng);
        $this->assertAttributeEquals(100, 'height', $this->imagePng);
        $this->assertAttributeEquals(IMAGETYPE_PNG, 'type', $this->imagePng);
        $this->assertAttributeEquals(
            realpath(
                TESTS_PATH . '/_resources/image_test_original.png'
            ),
            'filepath',
            $this->imagePng
        );
    }

    /**
     * Tests Image->scaleToWidth()
     */
    public function testScaleToWidth()
    {

        //gif
        $this->imageGif->scaleToWidth(20);
        $this->assertEquals(20, imagesx($this->imageGif->getImage()));

        //jpg
        $this->imageJpg->scaleToWidth(20);
        $this->assertEquals(20, imagesx($this->imageJpg->getImage()));

        //png
        $this->imagePng->scaleToWidth(20);
        $this->assertEquals(20, imagesx($this->imagePng->getImage()));
    }

    /**
     * Tests Image->scaleToHeight()
     */
    public function testScaleToHeight()
    {

        //gif
        $this->imageGif->scaleToHeight(20);
        $this->assertEquals(20, imagesy($this->imageGif->getImage()));

        //jpg
        $this->imageJpg->scaleToHeight(20);
        $this->assertEquals(20, imagesy($this->imageJpg->getImage()));

        //png
        $this->imagePng->scaleToHeight(20);
        $this->assertEquals(20, imagesy($this->imagePng->getImage()));
    }

    /**
     * Tests Image->scale()
     */
    public function testScale()
    {

        //gif
        $this->imageGif->scale(20, 30);
        $this->assertEquals(20, imagesx($this->imageGif->getImage()));
        $this->assertEquals(13, imagesy($this->imageGif->getImage()));

        $this->imageGif->scale(30, 20);
        $this->assertEquals(30, imagesx($this->imageGif->getImage()));
        $this->assertEquals(20, imagesy($this->imageGif->getImage()));

        //jpg
        $this->imageJpg->scale(20, 30);
        $this->assertEquals(20, imagesx($this->imageJpg->getImage()));
        $this->assertEquals(13, imagesy($this->imageJpg->getImage()));

        $this->imageJpg->scale(30, 20);
        $this->assertEquals(30, imagesx($this->imageJpg->getImage()));
        $this->assertEquals(20, imagesy($this->imageJpg->getImage()));

        //png
        $this->imagePng->scale(20, 30);
        $this->assertEquals(20, imagesx($this->imagePng->getImage()));
        $this->assertEquals(13, imagesy($this->imagePng->getImage()));

        $this->imagePng->scale(30, 20);
        $this->assertEquals(30, imagesx($this->imagePng->getImage()));
        $this->assertEquals(20, imagesy($this->imagePng->getImage()));
    }

    /**
     * Tests Image->rotate()
     */
    public function testRotate()
    {

        //gif
        $this->imageGif->rotate(90);
        $this->assertEquals(100, imagesx($this->imageGif->getImage()));
        $this->assertEquals(150, imagesy($this->imageGif->getImage()));
        $this->imageGif->rotate(-90);
        $this->assertEquals(100, imagesx($this->imageGif->getImage()));
        $this->assertEquals(150, imagesy($this->imageGif->getImage()));

        //jpg
        $this->imageJpg->rotate(90);
        $this->assertEquals(100, imagesx($this->imageJpg->getImage()));
        $this->assertEquals(150, imagesy($this->imageJpg->getImage()));
        $this->imageJpg->rotate(-90);
        $this->assertEquals(100, imagesx($this->imageJpg->getImage()));
        $this->assertEquals(150, imagesy($this->imageJpg->getImage()));

        //png
        $this->imagePng->rotate(90);
        $this->assertEquals(100, imagesx($this->imagePng->getImage()));
        $this->assertEquals(150, imagesy($this->imagePng->getImage()));
        $this->imagePng->rotate(-90);
        $this->assertEquals(100, imagesx($this->imagePng->getImage()));
        $this->assertEquals(150, imagesy($this->imagePng->getImage()));
    }

    /**
     * Tests Image->save()
     */
    public function testSave()
    {

        //gif
        $this->imageGif->scale(20, 30);
        $this->imageGif->save();
        $this->imageGif->save(realpath(TESTS_PATH . '/_resources') . DIRECTORY_SEPARATOR . 'image_test_saved.gif');
        $this->assertFileExists(realpath(TESTS_PATH . '/_resources/image_test_original.gif'));
        $this->assertFileExists(realpath(TESTS_PATH . '/_resources/image_test_saved.gif'));

        //jpg
        $this->imageJpg->scale(20, 30);
        $this->imageJpg->save();
        $this->imageJpg->save(realpath(TESTS_PATH . '/_resources') . DIRECTORY_SEPARATOR . 'image_test_saved.jpg');
        $this->assertFileExists(realpath(TESTS_PATH . '/_resources/image_test_original.jpg'));
        $this->assertFileExists(realpath(TESTS_PATH . '/_resources/image_test_saved.jpg'));

        //png
        $this->imagePng->scale(20, 30);
        $this->imagePng->save();
        $this->imagePng->save(realpath(TESTS_PATH . '/_resources') . DIRECTORY_SEPARATOR . 'image_test_saved.png');
        $this->assertFileExists(realpath(TESTS_PATH . '/_resources/image_test_original.png'));
        $this->assertFileExists(realpath(TESTS_PATH . '/_resources/image_test_saved.png'));
    }
}

