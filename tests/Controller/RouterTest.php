<?php
use Llama\Controller\Router;
use Llama\Controller\Route;

class RouterTest extends PHPUnit_Framework_TestCase
{
    private $router;
    private $route;

    protected function setUp()
    {
        $this->route = new Route(
            '/user/:id',
            array(
                'controller' => 'user',
                'action' => 'view'
            ),
            array('id' => '[\d]+')
        );
        $this->router = new Router('/user/1/');
        $this->router->addRoute($this->route);

        parent::setUp();
    }

    protected function tearDown()
    {
        $this->router = null;

        parent::tearDown();
    }

    /**
     * Test the Constructor of the Router class:
     *  - ensure the routes property is an empty array
     */
    public function testRouter()
    {
        $this->assertAttributeSame(array(), 'routes', new Router('/user/1/'));

        $_SERVER['REQUEST_URI'] = '/user/1';

        $this->assertAttributeSame('/user/1', 'uri', new Router());
    }

    /**
     * Test the addRoute method of the Router class:
     *  - ensure the routes property contains the added route
     */
    public function testAddRoute()
    {
        $this->assertAttributeContains($this->route, 'routes', $this->router);
    }

    /**
     * Test the addRoute method throws the correct exception when a duplicate rule is added.
     *
     * @expectedException \Llama\Controller\Exception
     */
    public function testAddRouteException()
    {
        $this->router->addRoute($this->route);
    }

    /**
     * Test the initialise method of the Router class:
     *  - ensure the matched property is true
     */
    public function testInitialise()
    {
        $this->router->initialise();

        $this->assertTrue($this->router->isMatched());
    }

    /**
     * Test the Constructor throws the correct exception when the router can't find a URI.
     *
     * @expectedException \Llama\Controller\Exception
     */
    public function testInitialiseThrowsExceptionForNoUri()
    {
        $router = new Router();
        $router->initialise();

        $this->assertAttributeSame(array(), 'routes', $router);
    }

    /**
     * Test the initialise method throws the correct exception when no routes have been added.
     *
     * @expectedException \Llama\Controller\Exception
     */
    public function testInitialiseException()
    {
        $router = new Router('/user/1/');
        $router->initialise();
    }

    /**
     * Test the setRoute method of the Router class:
     *  - ensure the controller is set
     *  - ensure the action is set
     *  - ensure the parameters are extracted
     *
     * @depends testInitialise
     */
    public function testSetRoute()
    {
        $this->router->initialise();

        $this->assertAttributeContains('user', 'controller', $this->router);
        $this->assertAttributeContains('view', 'action', $this->router);
        $this->assertAttributeSame(array('id' => '1'), 'params', $this->router);
    }

    /**
     * Test the getParam method of the Router class:
     *  - ensure the parameter is returned
     *  - ensure the default value is return for a non-existent parameter
     *
     * @depends testInitialise
     */
    public function testGetParam()
    {
        $this->router->initialise();

        $this->assertEquals(1, $this->router->getParam('id'));
        $this->assertEquals(2, $this->router->getParam('non_existent', 2));
    }

    /**
     * Test the isMatched method of the Router class:
     *  - ensure the isMatched method returns false when no route has matched
     *
     * @depends testInitialise
     */
    public function testIsMatched()
    {
        $this->assertFalse($this->router->isMatched());
        $this->router->initialise();
        $this->assertTrue($this->router->isMatched());
    }
}

