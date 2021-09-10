<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class LongestPostCalculator
 *
 * @package Statistics\Calculator
 */
class MaxPostLength extends AbstractCalculator
{

    protected const UNITS = 'characters';

    /**
     * @var int
     */
    private $maxPostLength = 0;

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $postLength = strlen($postTo->getText());

        if ($this->maxPostLength < $postLength) {
            $this->maxPostLength = $postLength;
        }
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        return (new StatisticsTo())->setValue($this->maxPostLength);
    }
}
