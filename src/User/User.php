<?php

namespace Bjos\User;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model.
 */
class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $username;
    public $password;
    public $firstname;
    public $surname;
    public $email;
    public $role;
    public $created;
    public $updated;
    public $ranking;
    public $votes;


    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the acronym and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $username  acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if acronym and password matches, else false.
     */
    public function verifyPassword($username, $password)
    {
        $this->find("username", $username);
        return password_verify($password, $this->password);
    }

    /**
     * Verify the acronym and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $username  acronym to check.
     *
     * @return boolean true if acronym and password matches, else false.
     */
    public function checkLoggedInUser($di, $username)
    {
        $user = $di->session->get("user", null);

        if (isset($user)) {
            if ($user["username"] === $username) {
                return true;
            }
        }
        return false;
    }
}
