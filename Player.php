<?php

final class Player
{
    public string $name;
    public array $hand;
    public string $status;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->hand = [];
        $this->status = "playing";
    }

    public function addCard(Card $card)
    {
        $this->hand[] = $card;
    }

    public function showHand(bool $isDealer = false): string
    {
        $cardsInHands = array_map(function ($card) {
            return $card->show();
        }, $this->hand);

        // Don't return the last card if the hand is the dealer's
        if ($isDealer) {
            array_pop($cardsInHands);
        }

        return implode(' ', $cardsInHands);
    }

    public function getScore(array $hand, bool $isDealer): int
    {
        $totalScore = 0;

        if ($isDealer == true) {
            array_pop($hand);
        }

        foreach ($hand as $card) {
            $totalScore += $card->score();
        }

        return $totalScore;
    }

    public function getHand(): array
    {
        return $this->hand;
    }
}