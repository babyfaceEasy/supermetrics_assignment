<?php

namespace SocialPost\Hydrator;

use SocialPost\Dto\SocialPostTo;

/**
 * Interface SocialPostHydratorInterface
 *
 * @package SocialPost\Hydrator
 */
interface SocialPostHydratorInterface
{

    /**
     * @param array $postData
     *
     * @return SocialPostTo
     */
    public function hydrate(array $postData): SocialPostTo;
}
