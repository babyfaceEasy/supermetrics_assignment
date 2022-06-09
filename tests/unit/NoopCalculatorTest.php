<?php

declare(strict_types = 1);

namespace Tests\Unit;

use Statistics\Dto\ParamsTo;
use PHPUnit\Framework\TestCase;
use SocialPost\Dto\SocialPostTo;
use Statistics\Calculator\NoopCalculator;
use SocialPost\Hydrator\FictionalPostHydrator;

class NoopCalculatorTest extends TestCase
{

    /**
     * @var NoopCalculator
     */
    private $noopCalculator;

    /**
     * @var SocialPostTo
     */
    private $postTo;

    protected function setUp(): void
    {
        parent::setUp();

        $postData = [
            "id" => "post629cf5356b342_e3b96302",
            "from_name" => "Woodrow Lindholm",
            "from_id" => "user_14",
            "message" => "dog horror mother option recognize ethics hike output estimate favor empire thinker tape outside habitat program pain horror convention detective integrity button reserve full truth retain boy money bend stride debt loose pole stand mean counter abbey lend good coalition stride risk connection trait circulation noble hand",
            "type" => "status",
            "created_time" => "2022-05-22T09:56:15+00:00"
        ];

        $paramsToMock = $this->createMock(ParamsTo::class);
        // stub gtStatName to return 'Average number of posts per user in a given month'
        $paramsToMock->method('getStatName')->willReturn('Average number of posts per user in a given month');
        $this->noopCalculator = new NoopCalculator();

        $this->noopCalculator->setParameters($paramsToMock);

        $hydrator = new FictionalPostHydrator();
        $this->postTo = $hydrator->hydrate($postData);
    }

    /** @test */
    public function there_are_no_user_daily_post_count_when_noop_calclator_is_created(): void
    {
        $this->assertEmpty((new NoopCalculator())->userDailyPostCount());
    }

    /** @test */
    public function it_does_do_accumulate(): void
    {
        $this->noopCalculator->doAccumulate($this->postTo);
        $expected = ["Woodrow Lindholm" => [22 => 1]];
        $this->assertSame($expected, $this->noopCalculator->userDailyPostCount());
    }

    /** @test */
    public function it_calculates_the_average_number_of_posts_per_user_per_month(): void
    {
        $this->noopCalculator->doAccumulate($this->postTo);
        $got = $this->noopCalculator->doCalculate();

        // assert that the averrage number of posts per month for each user is calculated
        $this->assertSame(1, count($got->getChildren()));
        $firstChild = $got->getChildren()[0]; 
        $this->assertSame($this->postTo->getAuthorName(), $firstChild->getSplitPeriod());
        $this->assertSame(1, (int)$firstChild->getValue());
        $this->assertSame(NoopCalculator::UNITS, $firstChild->getUnits());
    }
}