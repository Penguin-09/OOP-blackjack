<?php

final class Blackjack
{
    public function scoreHand(array $hand): string
    {
        $totalScore = 0;

        foreach ($hand as $card) {
            $totalScore += $card->score();
        }

        if ($totalScore > 21) {
            return 'Busted!';
        } elseif ($totalScore == 21) {
            if (count($hand) == 2) {
                return 'Blackjack!';
            } else {
                return 'Twenty-One';
            }
        } else {
            if (count($hand) == 5) {
                return 'Five Card Charlie';
            } else {
                return 'Score: ' . $totalScore;
            }
        }
    }
}