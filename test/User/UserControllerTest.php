<?php

namespace Bjos\User;

use PHPUnit\Framework\TestCase;
use Anax\Response\ResponseUtility;
use Anax\DI\DIFactoryConfig;

/**
 * Test GeoLocationController
 */
class UserControllerTest extends TestCase
{
    private $controller;

    /**
     * Setup the controller, before each testcase, just like the router
     * would set it up.
     */
    protected function setUp(): void
    {
        global $di;
        // Init service container $di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // $di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        $this->di = $di;

        // Create and initiate the controller
        $this->controller = new UserController();
        $this->controller->setDi($di);
        $this->controller->initialize();
    }

    /**
     * Test the route "loginAction" withhout logged in user
     */
    public function testLoginActionWithoutUser()
    {
        // $this->di->request->setGet("search", "2.2.2.2");
        $res = $this->controller->loginAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Test the route "loginAction" whith logged in user
     */
    public function testLoginActionWithSession()
    {
        $session = $this->di->get("session");
        $session->set("user", [
            "username" => "doe",
        ]);
        // var_dump($session);
        $res = $this->controller->loginAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Test the route "createAction".
     */
    public function testCreateAction()
    {
        $res = $this->controller->createAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Test the route "deleteAction".
     */
    public function testDeleteAction()
    {
        $session = $this->di->get("session");
        $session->delete("user");
        // var_dump($this->di->get("session"));
        $res = $this->controller->deleteAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Test the route "updateAction".
     */
    public function testUpdateAction()
    {
        $session = $this->di->get("session");
        $session->delete("user");
        // var_dump($this->di->get("session"));
        $res = $this->controller->updateAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    /**
     * Test the route "logoutAction".
     */
    public function testLogoutAction()
    {
        $res = $this->controller->logoutAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
