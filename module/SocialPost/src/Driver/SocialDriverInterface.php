<?php

namespace SocialPost\Driver;

use Traversable;

/**
 * Class SocialApiDriverInterface
 *
 * @package SocialPost\Driver
 */
interface SocialDriverInterface
{

    /**
     * @param int $page
     *
     * @return Traversable
     */
    public function fetchPostsByPage(int $page): Traversable;
}
