<?php

namespace SocialPost\Dto;

use DateTime;

/**
 * Class SocialPostTo
 *
 * @package SocialPost\Dto
 */
class SocialPostTo
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $authorId;

    /**
     * @var string
     */
    private $authorName;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $type;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAuthorId(): ?string
    {
        return $this->authorId;
    }

    /**
     * @return string|null
     */
    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param string|null $id
     *
     * @return $this
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string|null $authorId
     *
     * @return $this
     */
    public function setAuthorId(?string $authorId): self
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * @param string|null $authorName
     *
     * @return $this
     */
    public function setAuthorName(?string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @param string|null $text
     *
     * @return $this
     */
    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param string|null $type
     *
     * @return $this
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param DateTime|null $date
     *
     * @return $this
     */
    public function setDate(?DateTime $date): self
    {
        $this->date = $date;

        return $this;
    }
}
