<?php

namespace Bjos\UserPage;

// use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class UserPage
{
    private $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

    /**
     * Verify the logged in user.
     *
     * @param string $username acronym to check.
     *
     * @return boolean true if username and $_SESSION["user"]["username"] matches, else false.
     */
    public function checkLoggedInUser($username)
    {
        $user = $this->di->session->get("user", null);

        if (isset($user)) {
            if ($user["username"] === $username) {
                return true;
            }
        }
        return false;
    }
}
