<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class Calculator
 *
 * @package Statistics\Calculator
 */
class AveragePostLength extends AbstractCalculator
{

    protected const UNITS = 'characters';

    /**
     * @var int
     */
    private $totalLength = 0;

    /**
     * @var int
     */
    private $postCount = 0;

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $this->postCount++;
        $this->totalLength += strlen($postTo->getText());
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        $value = $this->postCount > 0
            ? $this->totalLength / $this->postCount
            : 0;

        return (new StatisticsTo())->setValue(round($value,2));
    }
}
