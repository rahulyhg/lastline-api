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
                    'value' => 11,
                    'kickers' => [12, 9, 7],
                ],
            ],
            'two_pair' => [
                ['card_diamond_12', 'card_hearts_6', 'card_diamond_11', 'card_hearts_11', 'card_clubs_12', 'card_spades_7', 'card_clubs_9'],
                [
                    'rank' => PokerHandEvaluator::TWO_PAIR,
                    'high_value' => 12,
                    'low_value' => 11,
                    'kicker' => [9],
                ],
            ],
            'three_of_a_kind' => [
                ['card_diamond_3', 'card_hearts_6', 'card_diamond_11', 'card_hearts_11', 'card_clubs_12', 'card_spades_7', 'card_clubs_11'],
                [
                    'rank' => PokerHandEvaluator::THREE_OF_A_KIND,
                    'value' => 11,
                    'kickers' => [12, 7],
                ],
            ],
            'straight' => [
                ['card_diamond_3', 'card_hearts_6', 'card_diamond_11', 'card_hearts_5', 'card_clubs_4', 'card_spades_7', 'card_clubs_11'],
                [
                    'rank' => PokerHandEvaluator::STRAIGHT,
                    'value' => 7,
                ],
            ],
            'flush' => [
                ['card_hearts_3', 'card_hearts_6', 'card_diamond_11', 'card_hearts_5', 'card_hearts_4', 'card_spades_7', 'card_hearts_11'],
                [
                    'rank' => PokerHandEvaluator::FLUSH,
                    'values' => [11, 6, 5, 4, 3],
                ],
            ],
            'full_house' => [
                ['card_hearts_3', 'card_hearts_6', 'card_diamond_3', 'card_spades_3', 'card_hearts_11', 'card_spades_7', 'card_hearts_11'],
                [
                    'rank' => PokerHandEvaluator::FULL_HOUSE,
                    'three_of_a_kind_value' => 3,
                    'pair_value' => 11,
                ],
            ],
        ];
    }

    /**
     * @dataProvider cardProvider
     */
    public function testEvaluate(array $cards, array $expectedResult)
    {
        $evaluator = new PokerHandEvaluator();

        $result = $evaluator->evaluate($cards);

        $this->assertEquals($expectedResult, $result);
    }
}