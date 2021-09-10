<?php

namespace App\Controller;

use DateTime;
use SocialPost\Service\SocialPostService;
use Statistics\Builder\ParamsBuilder;
use Statistics\Enum\StatsEnum;
use Statistics\Extractor\StatisticsToExtractor;
use Statistics\Service\StatisticsService;

/**
 * Class StatisticsController
 *
 * @package App\Controller
 */
class StatisticsController extends Controller
{

    private const STAT_LABELS = [
        StatsEnum::TOTAL_POSTS_PER_WEEK         => 'Total posts split by week',
        StatsEnum::AVERAGE_POST_NUMBER_PER_USER => 'Average number of posts per user in a given month',
        StatsEnum::AVERAGE_POST_LENGTH          => 'Average character length/post in a given month',
        StatsEnum::MAX_POST_LENGTH              => 'Longest post by character length in a given month',
    ];

    /**
     * @var StatisticsService
     */
    private $statsService;

    /**
     * @var SocialPostService
     */
    private $socialService;

    /**
     * @var StatisticsToExtractor
     */
    private $extractor;

    /**
     * StatisticsController constructor.
     *
     * @param StatisticsService     $statsService
     * @param SocialPostService     $socialService
     * @param StatisticsToExtractor $extractor
     */
    public function __construct(
        StatisticsService $statsService,
        SocialPostService $socialService,
        StatisticsToExtractor $extractor
    ) {
        $this->statsService  = $statsService;
        $this->socialService = $socialService;
        $this->extractor     = $extractor;
    }

    /**
     * @param array $params
     */
    public function indexAction(array $params)
    {
        try {
            $date   = $this->extractDate($params);
            $params = ParamsBuilder::reportStatsParams($date);

            $posts = $this->socialService->fetchPosts();
            $stats = $this->statsService->calculateStats($posts, $params);

            $response = [
                'stats' => $this->extractor->extract($stats, self::STAT_LABELS),
            ];
        } catch (\Throwable $throwable) {
            http_response_code(500);

            $response = ['message' => 'An error occurred'];
        }

        $this->render($response, 'json', false);
    }

    /**
     * @param array $params
     *
     * @return DateTime
     */
    private function extractDate(array $params): DateTime
    {
        $month = $params['month'] ?? null;
        $date  = DateTime::createFromFormat('F, Y', $month);

        if (false === $date) {
            $date = new DateTime();
        }

        return $date;
    }
}
