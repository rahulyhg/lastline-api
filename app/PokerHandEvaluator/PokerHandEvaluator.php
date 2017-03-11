<?php

namespace App\PokerHandEvaluator;

class PokerHandEvaluator
{
    const HIGH_CARD = 1;
    const ONE_PAIR = 2;

    private $cards = [];

    public function evaluate(array $cards) : array
    {
        $this->convertCards($cards);
        $this->sortByValue();

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

    private function isPair()
    {
        $previous = false;

        foreach ($this->cards as $card)
        {
            if (!$previous) {
                $previous = $card;

                continue;
            }

            if ($previous['value'] == $card['value'])
            {
                return [
                    'rank' => self::ONE_PAIR,
                    'pair_value' => $card['value'],
                    'kickers' => $this->selectHighestValues(3, [$previous['id'], $card['id']]),
                ];
            }

            $previous = $card;
        }

        return false;
    }

    private function isHighCard()
    {
        return [
            'rank' => self::HIGH_CARD,
            'values' => $this->selectHighestValues(),
        ];
    }

    private function selectHighestValues(int $count = 5, array $notIn = [])
    {
        $cardValues = [];

        foreach ($this->cards as $card)
        {
            if (in_array($card['id'], $notIn))
            {
                continue;
            }

            $cardValues[] = $card['value'];

            if (count($cardValues) == $count) {
                break;
            }
        }

        return $cardValues;
    }
}