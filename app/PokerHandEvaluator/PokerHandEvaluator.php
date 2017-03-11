<?php

namespace App\PokerHandEvaluator;

class PokerHandEvaluator
{
    const HIGH_CARD = 1;
    const ONE_PAIR = 2;
    const TWO_PAIR = 3;
    const THREE_OF_A_KIND = 4;
    const STRAIGHT = 5;
    const FLUSH = 6;

    private $cards = [];

    public function evaluate(array $cards) : array
    {
        $this->convertCards($cards);
        $this->sortByValue();

        if ($result = $this->isFlush())
        {
            return $result;
        }

        if ($result = $this->isStraight())
        {
            return $result;
        }

        if ($result = $this->isThreeOfAKind())
        {
            return $result;
        }

        if ($result = $this->isTwoPair())
        {
            return $result;
        }

        if ($result = $this->isPair())
        {
            return $result;
        }

        return $this->isHighCard();
    }

    private function convertCards(array $cards)
    {
        foreach ($cards as $card) {
            $parts = explode('_', $card);

            $this->cards[] = [
                'id' => $card,
                'color' => $parts[1],
                'value' => (int)$parts[2],
            ];
        }
    }

    private function sortByValue()
    {
        usort($this->cards, function($a, $b) {
            return $b['value'] - $a['value'];
        });
    }

    private function isFlush()
    {
        $cardsOfColors = [
            'diamond' => [],
            'hearts' => [],
            'clubs' => [],
            'spades' => [],
        ];

        foreach ($this->cards as $card)
        {
            $cardsOfColors[$card['color']][] = $card;

            if (count($cardsOfColors[$card['color']]) == 5)
            {
                return [
                    'rank' => self::FLUSH,
                    'values' => $this->selectHighestValues($cardsOfColors[$card['color']]),
                ];
            }
        }
    }

    private function isStraight()
    {
        $cardsInStraight = [];

        foreach ($this->cards as $card)
        {
            if (empty($cardsInStraight) || end($cardsInStraight)['value'] - 1 == $card['value'])
            {
                $cardsInStraight[] = $card;
            } else {
                $cardsInStraight = [$card];
            }

            if (count($cardsInStraight) == 5)
            {
                return [
                    'rank' => self::STRAIGHT,
                    'value' => $cardsInStraight[0]['value'],
                ];
            }
        }

        return false;
    }

    private function isThreeOfAKind()
    {
        $threeOfAKind = $this->findCardsWithSameValue($this->cards, 3);

        if (!$threeOfAKind)
        {
            return false;
        }

        return [
            'rank' => self::THREE_OF_A_KIND,
            'value' => $threeOfAKind[0]['value'],
            'kickers' => $this->selectHighestValues($this->excludeCards($threeOfAKind), 2),
        ];
    }

    private function isTwoPair()
    {
        $highPair = $this->findCardsWithSameValue($this->cards);

        if (!$highPair)
        {
            return false;
        }

        $lowPair = $this->findCardsWithSameValue($this->excludeCards($highPair));

        if (!$lowPair)
        {
            return false;
        }

        return [
            'rank' => self::TWO_PAIR,
            'high_value' => $highPair[0]['value'],
            'low_value' => $lowPair[0]['value'],
            'kicker' => $this->selectHighestValues($this->excludeCards(array_merge($highPair, $lowPair)), 1),
        ];
    }

    private function isPair()
    {
        $pair = $this->findCardsWithSameValue($this->cards);

        if (!$pair)
        {
            return false;
        }

        return [
            'rank' => self::ONE_PAIR,
            'value' => $pair[0]['value'],
            'kickers' => $this->selectHighestValues($this->excludeCards($pair), 3),
        ];
    }

    private function isHighCard() : array
    {
        return [
            'rank' => self::HIGH_CARD,
            'values' => $this->selectHighestValues($this->cards),
        ];
    }

    private function findCardsWithSameValue(array $cards, $neededCount = 2)
    {
        $sameCards = [];

        foreach ($cards as $card)
        {
            if (empty($sameCards) || $sameCards[0]['value'] == $card['value'])
            {
                $sameCards[] = $card;
            } else {
                $sameCards = [$card];
            }

            if (count($sameCards) == $neededCount)
            {
                return $sameCards;
            }
        }

        return false;
    }

    private function excludeCards(array $cardsToExclude) : array
    {
        $remainedCards = [];

        foreach ($this->cards as $card)
        {
            if (in_array($card, $cardsToExclude))
            {
                continue;
            }

            $remainedCards[] = $card;
        }

        return $remainedCards;
    }

    private function selectHighestValues(array $cards, int $count = 5) : array
    {
        $cardValues = [];

        foreach ($cards as $card)
        {
            $cardValues[] = $card['value'];

            if (count($cardValues) == $count) {
                break;
            }
        }

        return $cardValues;
    }
}