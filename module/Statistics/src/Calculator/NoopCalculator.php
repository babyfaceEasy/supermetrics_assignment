<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class NoopCalculator extends AbstractCalculator
{
    protected const UNITS = 'posts';

    private array $userDailyPostCount = [];

    public function userDailyPostCount(): array
    {
        return $this->userDailyPostCount;
    }

    /**
     * @inheritDoc
     */
    public function doAccumulate(SocialPostTo $postTo): void
    {
        // Noops!
        $userKey = $postTo->getAuthorName();
        if (!isset($this->userDailyPostCount[$userKey])) {
            $this->userDailyPostCount[$userKey] = [];
        }

        $dailyKey = $postTo->getDate()->format('j');
        $this->userDailyPostCount[$userKey][$dailyKey] = ($this->userDailyPostCount[$userKey][$dailyKey] ?? 0) + 1;
    }

    /**
     * @inheritDoc
     */
    public function doCalculate(): StatisticsTo
    {
        $stats =  new StatisticsTo();
        foreach ($this->userDailyPostCount as $userKey => $dailyPostCount) {
            $child = (new StatisticsTo())
                ->setName($this->parameters->getStatName())
                ->setSplitPeriod($userKey)
                ->setValue($this->getAverage($dailyPostCount))
                ->setUnits(SELF::UNITS);

                $stats->addChild($child);
        }

        return $stats;
    }

    private function getAverage(array $dailyPostCount): int
    {
        if (!$dailyPostCount) return 0;

        return (int) (array_sum($dailyPostCount) / count($dailyPostCount));
    }
}
