<?php

namespace SocialPost\Hydrator;

use DateTime;
use SocialPost\Dto\SocialPostTo;

/**
 * Class FictionalPostHydrator
 *
 * @package SocialPost\Hydrator
 */
class FictionalPostHydrator implements SocialPostHydratorInterface
{

    private const POST_CREATED_DATE_FORMAT = DateTime::ATOM;

    /**
     * @param array $postData
     *
     * @return SocialPostTo
     */
    public function hydrate(array $postData): SocialPostTo
    {
        $dto = (new SocialPostTo())
            ->setId($postData['id'] ?? null)
            ->setAuthorName($postData['from_name'] ?? null)
            ->setAuthorId($postData['from_id'] ?? null)
            ->setText($postData['message'] ?? null)
            ->setType($postData['type'] ?? null)
            ->setDate($this->hydrateDate($postData['created_time'] ?? null));

        return $dto;
    }

    /**
     * @param string|null $date
     *
     * @return DateTime|null
     */
    private function hydrateDate(?string $date): ?DateTime
    {
        $date = DateTime::createFromFormat(
            self::POST_CREATED_DATE_FORMAT,
            $date
        );

        return false === $date ? null : $date;
    }
}
