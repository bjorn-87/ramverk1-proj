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
}
