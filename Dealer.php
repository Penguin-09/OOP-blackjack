<?php

final class Dealer
{
    private Blackjack $blackjack;
    private Deck $deck;
    private array $players;
    private Player $dealerPlayer;

    public function __construct(Blackjack $blackjack, Deck $deck)
    {
        $this->blackjack = $blackjack;
        $this->deck = $deck;
        $this->players = [];
        $this->dealerPlayer = new Player('Dealer');
    }

    public function addPlayer(Player $player)
    {
        $this->players[] = $player;
    }

    public function playGame()
    { 
        // Deal two cards to each player
        foreach ($this->players as $player) {
            $player->addCard($this->deck->drawCard());
            $player->addCard($this->deck->drawCard());
        }

        // Deal two cards to dealer
        $this->dealerPlayer->addCard($this->deck->drawCard());
        $this->dealerPlayer->addCard($this->deck->drawCard());

        // Check if any player has blackjack
        foreach ($this->players as $player) {
            if ($this->blackjack->scoreHand($player->getHand()) == 'Blackjack!') {
                $player->status = 'blackjack';
                echo $player->name . ' has Blackjack!' . PHP_EOL . 'GAME OVER' . PHP_EOL . 
                'Dealer had ' . $this->dealerPlayer->showHand(false) . ': ' . $this->blackjack->scoreHand($this->dealerPlayer->hand, false) . PHP_EOL;
                foreach ($this->players as $player) {
                    echo $player->name . ' had ' . $player->showHand(false) . ': ' . $this->blackjack->scoreHand($player->hand, false) . PHP_EOL;
                }
                
                exit;
            }
        }

        $finishedPlayers = 0;

        // Display dealer hand
        echo 'Dealer has ' . $this->dealerPlayer->showHand(true) . ' and an unknown card.' . PHP_EOL . '----------------------' . PHP_EOL;

        while ($finishedPlayers < count($this->players)) {
            // Players take turns
            foreach ($this->players as $player) {
                if ($player->status == 'playing') {
                    echo $player->name . "'s turn." . PHP_EOL;
                    $playerChoice = readline($player->name . ' has ' . $player->showHand(false) . ' (total: ' . $player->getScore($player->hand, false) . '). hit (h) or stand (s)? ');

                    if ($playerChoice == "h") {
                        $player->addCard($this->deck->drawCard());
                        echo $player->name . ' draws a card. their hand is now ' . $player->showHand(false) . ' (total: ' . $player->getScore($player->hand, false) . ')' . PHP_EOL;
                        // Bust player if hand is over 21
                        if ($player->getScore($player->hand, false) > 21) {
                            $player->status = 'bust';
                            echo $player->name . ' busts!' . PHP_EOL;
                            $finishedPlayers++;
                        }
                    } else if ($playerChoice == "s") {
                        $player->status = 'stand';
                        $finishedPlayers++;
                        echo $player->name . ' stands.' . PHP_EOL;
                    } else {
                        $player->status = 'stand';
                        $finishedPlayers++;
                        echo 'Invalid input. ' . $player->name . ' stands.' . PHP_EOL;
                    }

                    echo '----------------------' . PHP_EOL;
                }
            }

            // Stop if all players have stood
            if ($finishedPlayers == count($this->players)) {
                break;
            }
        }

        // Dealer draws cards until score is 17 or higher
        while ($this->dealerPlayer->getScore($this->dealerPlayer->hand, true) < 17) {
            $this->dealerPlayer->addCard($this->deck->drawCard());
        }
        
        echo 'GAME OVER' . PHP_EOL . 'Dealer had ' . $this->dealerPlayer->showHand(false) . ': ' . $this->blackjack->scoreHand($this->dealerPlayer->hand, false) . PHP_EOL;
        foreach ($this->players as $player) {
            echo $player->name . ' had ' . $player->showHand(false) . ': ' . $this->blackjack->scoreHand($player->hand, false) . PHP_EOL;
        }
    }
}