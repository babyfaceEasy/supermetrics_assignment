<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\ParamsTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class AbstractCalculator
 *
 * @package Statistics\Calculator
 */
abstract class AbstractCalculator implements CalculatorInterface
{

    protected const UNITS = null;

    /**
     * @var ParamsTo
     */
    protected $parameters;

    /**
     * @param ParamsTo $params
     *
     * @return CalculatorInterface
     */
    public function setParameters(ParamsTo $params): CalculatorInterface
    {
        $this->parameters = $params;

        return $this;
    }

    /**
     * @param SocialPostTo $postTo
     */
    public function accumulateData(SocialPostTo $postTo): void
    {
        if (false === $this->checkPost($postTo)) {
            return;
        }

        $this->doAccumulate($postTo);
    }

    /**
     * @return StatisticsTo
     */
    public function calculate(): StatisticsTo
    {
        return $this->doCalculate()
                    ->setName($this->parameters->getStatName())
                    ->setUnits(static::UNITS);
    }

    /**
     * @param SocialPostTo $postTo
     *
     * @return bool
     */
    protected function checkPost(SocialPostTo $postTo): bool
    {
        if (null !== $this->parameters->getStartDate()
            && $this->parameters->getStartDate() > $postTo->getDate()
        ) {
            return false;
        }

        if (null !== $this->parameters->getEndDate()
            && $this->parameters->getEndDate() < $postTo->getDate()
        ) {
            return false;
        }

        return true;
    }

    /**
     * @param SocialPostTo $postTo
     */
    abstract protected function doAccumulate(SocialPostTo $postTo): void;

    /**
     * @return StatisticsTo
     */
    abstract protected function doCalculate(): StatisticsTo;
}
