<?php

namespace Bjos\Gravatar;

/**
 * Returns a gravatar
 */
class Gravatar
{
    /**
     * Url to get gravatar.
     */
    private $url;

    /**
     * Url to get gravatar.
     */
    public function __construct()
    {
        $this->url = 'https://www.gravatar.com/avatar/';
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $size Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $def Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $rat Maximum rating (inclusive) [ g | pg | r | x ]
     * @param bool $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return string containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    public function getGravatar($email, $size = 80, $def = 'mp', $rat = 'g', $img = false, $atts = array())
    {
        $url = $this->url;

        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$size&d=$def&r=$rat";

        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }
        return $url;
    }
}
