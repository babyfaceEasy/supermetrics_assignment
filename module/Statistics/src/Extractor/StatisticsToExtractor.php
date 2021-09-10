<?php

namespace Statistics\Extractor;

use Statistics\Dto\StatisticsTo;

/**
 * Class StatisticsToExtractor
 *
 * @package Statistics\Extractor
 */
class StatisticsToExtractor
{

    /**
     * @param StatisticsTo $statisticsTo
     * @param array        $labels
     *
     * @return array
     */
    public function extract(StatisticsTo $statisticsTo, array $labels): array
    {
        $label = isset($labels[$statisticsTo->getName()])
            ? $labels[$statisticsTo->getName()]
            : null;

        $extracted = [
            'name'        => $statisticsTo->getName(),
            'label'       => $label,
            'value'       => $statisticsTo->getValue(),
            'units'       => $statisticsTo->getUnits(),
            'splitPeriod' => $statisticsTo->getSplitPeriod(),
        ];

        if (empty($statisticsTo->getChildren())) {
            $extracted['children'] = null;

            return $extracted;
        }

        $children = [];
        foreach ($statisticsTo->getChildren() as $child) {
            $children[] = $this->extract($child, $labels);
        }

        $extracted['children'] = $children;

        return $extracted;
    }
}