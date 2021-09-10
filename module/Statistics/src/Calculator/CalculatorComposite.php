<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class Calculator
 *
 * @package Statistics\Calculator
 */
class CalculatorComposite implements CalculatorInterface
{

    /**
     * @var CalculatorInterface[]
     */
    private $children = [];

    /**
     * @param CalculatorInterface $child
     *
     * @return CalculatorComposite
     */
    public function addChild(CalculatorInterface $child): self
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * @param SocialPostTo $postTo
     */
    public function accumulateData(SocialPostTo $postTo): void
    {
        foreach ($this->children as $key => $child) {
            $child->accumulateData($postTo);
        }
    }

    /**
     * @return StatisticsTo
     */
    public function calculate(): StatisticsTo
    {
        $statistics = new StatisticsTo();

        foreach ($this->children as $key => $child) {
            $statistics->addChild($child->calculate());
        }

        return $statistics;
    }
}
