<?php

namespace Statistics\Dto;

/**
 * Interface StatisticsTo
 *
 * @package Statistics\Dto
 */
class StatisticsTo
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $splitPeriod;

    /**
     * @var string
     */
    private $units;

    /**
     * @var StatisticsTo[]
     */
    private $children = [];

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return float|null
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * @return StatisticsTo[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param float $value
     *
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param StatisticsTo $child
     *
     * @return $this
     */
    public function addChild(StatisticsTo $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSplitPeriod(): ?string
    {
        return $this->splitPeriod;
    }

    /**
     * @param string $splitPeriod
     *
     * @return $this
     */
    public function setSplitPeriod(string $splitPeriod): self
    {
        $this->splitPeriod = $splitPeriod;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnits(): ?string
    {
        return $this->units;
    }

    /**
     * @param string|null $units
     *
     * @return $this
     */
    public function setUnits(?string $units): self
    {
        $this->units = $units;

        return $this;
    }
}