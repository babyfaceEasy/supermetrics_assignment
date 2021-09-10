<?php

namespace SocialPost\Dto;

/**
 * Class ParamsTo
 *
 * @package SocialPost\Dto
 */
class FetchParamsTo
{

    /**
     * @var int
     */
    private $pageLimit;

    /**
     * @var int
     */
    private $pageOffset;

    /**
     * FetchParamsTo constructor.
     *
     * @param int $pageLimit
     * @param int $pageOffset
     */
    public function __construct(int $pageLimit, int $pageOffset = 1)
    {
        $this->pageLimit  = $pageLimit;
        $this->pageOffset = $pageOffset;
    }

    /**
     * @return int
     */
    public function getPageLimit(): int
    {
        return $this->pageLimit;
    }

    /**
     * @return int
     */
    public function getPageOffset(): int
    {
        return $this->pageOffset;
    }
}
