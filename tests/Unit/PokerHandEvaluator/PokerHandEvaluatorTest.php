<?php

namespace Tests\Unit\PokerHandEvaluator;

use App\PokerHandEvaluator\PokerHandEvaluator;
use Tests\TestCase;

class PokerHandEvaluatorTest extends TestCase
{
    public function cardProvider() : array
    {
        return [
            'high_card' => [
                ['card_diamond_2', 'card_hearts_8', 'card_diamond_11', 'card_hearts_3', 'card_clubs_12', 'card_spades_7', 'card_clubs_9'],
                [
                    'rank' => PokerHandEvaluator::HIGH_CARD,
                    'values' => [12, 11, 9, 8, 7],
                ],
            ],
            'one_pair' => [
                ['card_diamond_2', 'card_hearts_6', 'card_diamond_11', 'card_hearts_11', 'card_clubs_12', 'card_spades_7', 'card_clubs_9'],
                [
                    'rank' => PokerHandEvaluator::ONE_PAIR,
                    'pair_value' => 11,
                    'kickers' => [12, 9, 7],
                ],
            ],
        ];
    }

    /**
     * @dataProvider cardProvider
     */
    public function testIsHighCard(array $cards, array $expectedResult)
    {
        $evaluator = new PokerHandEvaluator();

        $result = $evaluator->evaluate($cards);

        $this->assertEquals($expectedResult, $result);
    }
}