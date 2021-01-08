<?php

namespace Bjos\UserPage;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Bjos\UserPage\UserPage;

// use Bjos\User\HTMLForm\CreateUserForm;
// use Bjos\User\HTMLForm\UpdateUserForm;
// use Bjos\User\HTMLForm\DeleteUserForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserPageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var $data description
     */
    private $session;
    private $gravatar;



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->session = $this->di->get("session");
        $this->gravatar = $this->di->get("gravatar");
        $this->user = $this->di->get("user");
        $this->userpage = new UserPage($this->di);
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $user = $this->user;
        $user->setDb($this->di->get("dbqb"));
        $gravatar = $this->gravatar;

        // var_dump($this->di->session->get("user"));
        $page->add("user/crud/view-all", [
            "items" => $user->findAllWhere("DELETED IS NULL", []),
            "gravatar" => $gravatar,
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    /**
     * Userpage
     *
     * @param int $id the id to update.
     *
     * @return void
     */
    public function userAction($username) : object
    {
        $page = $this->di->get("page");
        $user = $this->user;
        $user->setDb($this->di->get("dbqb"));
        $gravatar = $this->gravatar;

        if (!$user) {
            $this->di->get("response")->redirect("user/login")->send();
        }

        $currentUser = $this->userpage->checkLoggedInUser($username);

        if ($currentUser) {
            $userPage = "userpage/userpageadmin";
        } else {
            $userPage = "userpage/userpage";
        }

        $page->add($userPage, [
            "items" => $user->find("username", $username),
            "gravatar" => $gravatar->getGravatar($user->email),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }
}
