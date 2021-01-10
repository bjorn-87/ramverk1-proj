<?php

namespace Bjos\User;

/**
 * A mock class.
 * @SuppressWarnings("unused")
 */
class UserMock extends User
{
    public function find($column, $value) : object
    {
        $column = new User();
        $value = "test";
        return $column;
    }
}
