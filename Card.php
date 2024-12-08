<?php

final class Card
{
    private string $suit;
    private string $value;

    public function __construct(string $suit, string $value)
    {     
        $this->suit = $suit;
        $this->value = $value;
    }

    public function show()
    {
        switch ($this->suit) {
            case 'Hearts':
                $output = '[♥';
                break;
            case 'Diamonds':
                $output = '[♦';
                break;
            case 'Clubs':
                $output = '[♣';
                break;
            case 'Spades':
                $output = '[♠';
                break;
            default:
                $output = '[?';
        }

        $output .= ' ';

        switch ($this->value) {
            case 'Jack':
                $output .= 'J]';
                break;
            case 'Queen':
                $output .= 'Q]';
                break;
            case 'King':
                $output .= 'K]';
                break;
            case 'Ace':
                $output .= 'A]';
                break;
            default:
                $output .= $this->value . ']';
        }
        return $output;
    }

    public function score(): int
    {
        switch ($this->value) {
            case '2':
            case '3':
            case '4':
            case '5':
            case '6':
            case '7':
            case '8':
            case '9':
            case '10':
                return (int) $this->value;
                break;
            case 'Jack':
            case 'Queen':
            case 'King':
                return 10;
                break;
            case 'Ace':
                return 11;
                break;
        }   
    }
}