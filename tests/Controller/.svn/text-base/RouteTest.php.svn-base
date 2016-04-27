<?php
use Llama\Controller\Route;

class RouteTest extends PHPUnit_Framework_TestCase
{
    private $route;
    private $defaultRoute;

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
        $this->defaultRoute = new Route('/:controller/:action/:id/');
        $this->defaultRoute->match('/user/view/1/');

        parent::setUp();
    }

    protected function tearDown()
    {
        $this->route = null;
        $this->defaultRoute = null;

        parent::tearDown();
    }

    /**
     * Test the Constructor of the Route class:
     *  - ensure the rule is set
     *  - ensure the constraints are set
     *  - ensure the controller is set
     *  - ensure the action is set
     */
    public function testRoute()
    {
        $this->assertAttributeContains('/user/:id', 'rule', $this->route);
        $this->assertAttributeSame(array('id' => '[\d]+'), 'constraints', $this->route);
        $this->assertAttributeContains('user', 'controller', $this->route);
        $this->assertAttributeContains('view', 'action', $this->route);
    }

    /**
     * Test the Constructor throws the correct exception when no rule is passed.
     *
     * @expectedException \Llama\Controller\Exception
     */
    public function testRouteException()
    {
        new Route();
    }

    /**
     * Test the match method of the Route class:
     *  - ensure a correct route matches
     *  - ensure the parameters are extracted
     *  - ensure an incorrect route does not match
     *
     *  - ensure the controller is extracted from the route
     *  - ensure the action is extracted from the route
     */
    public function testMatch()
    {
        $this->assertTrue($this->route->match('/user/1'));
        $this->assertAttributeSame(array('id' => '1'), 'params', $this->route);
        $this->assertFalse($this->route->match('/user/one'));

        $this->assertAttributeContains('user', 'controller', $this->defaultRoute);
        $this->assertAttributeContains('view', 'action', $this->defaultRoute);
    }

    /**
     * Test the getConstraint method of the Route class:
     *  - ensure the correct constraint is return
     *  - ensure the default constraint is return
     */
    public function testGetConstraint()
    {
        $this->assertEquals('([\d]+)', $this->route->getConstraint(array(':id')));
        $this->assertEquals('([a-zA-Z0-9_\+\-%]+)', $this->route->getConstraint(array(':no_constraint')));
    }
}

