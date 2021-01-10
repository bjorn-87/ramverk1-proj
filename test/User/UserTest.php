<?php

namespace Bjos\User;

use PHPUnit\Framework\TestCase;
use Anax\Response\ResponseUtility;
use Anax\DI\DIMagic;

/**
 * Test User
 */
class UserTest extends TestCase
{
    private $user;

    protected function setUp() : void
    {
        global $di;

        // Setup di
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // $di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        $this->di = $di;
        $this->user = new UserMock();
    }

    /**
     * Test to create an object.
     */
    public function testCreateObject()
    {
        $this->assertInstanceOf("\Bjos\User\User", $this->user);
    }

    /**
     * Test to create an object.
     */
    public function testSetPassword()
    {
        $this->user->setPassword("test");
        $res = $this->user->password;
        // $password = "$2y$10$5RWBydI/rhc/zlr2fKZ5eOpQryrxaq6B7fh.8tEke1Ajw3/m1Je9W";
        $this->assertEquals($res, $this->user->password);
    }

    /**
     * Test to create an object.
     */
    public function testVerifyPassword()
    {
        $this->user->setPassword("test");
        $res = $this->user->verifyPassword("test", "test");
        // $password = "$2y$10$5RWBydI/rhc/zlr2fKZ5eOpQryrxaq6B7fh.8tEke1Ajw3/m1Je9W";
        $this->assertTrue($res);
    }
}
