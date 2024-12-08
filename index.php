<?php

// ! The Blackjack rules displayed in the exercise are not correct.
// My code is based on the real rules, except for the aces. Those always count as 11.

require_once 'Blackjack.php';
require_once 'Card.php';
require_once 'Dealer.php';
require_once 'Deck.php';
require_once 'Player.php';

$dealer = new Dealer(new Blackjack(), new Deck());
$dealer->addPlayer(new Player('Player 1'));
$dealer->addPlayer(new Player('Player 2'));
$dealer->playGame();