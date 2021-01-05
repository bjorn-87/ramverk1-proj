<?php

namespace Bjos\StartPage;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class StartPageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        // $user = new User();
        // $user->setDb($this->di->get("dbqb"));

        // var_dump($this->di->session->get("user"));
        $page->add("startpage/startpage");

        return $page->render([
            "title" => "Welcome",
        ]);
    }
}
