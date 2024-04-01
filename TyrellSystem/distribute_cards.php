<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function distributeCards($numPeople) {
    // Check if input value exists and is valid
    if (!is_numeric($numPeople) || $numPeople <= 0) {
        return ["error" => "Invalid input value"];
    }

    // Define card suits and values
    $suits = ['S', 'H', 'D', 'C'];
    $values = ['A', 2, 3, 4, 5, 6, 7, 8, 9, 'X', 'J', 'Q', 'K'];

    // Create the deck
    $deck = [];
    foreach ($suits as $suit) {
        foreach ($values as $value) {
            $deck[] = $suit . '-' . $value;
        }
    }

    // Shuffle the deck
    shuffle($deck);

    // Calculate the number of cards per person and the remaining cards
    $totalCards = count($deck);
    $cardsPerPerson = floor($totalCards / $numPeople);
    $remainingCards = $totalCards % $numPeople;

    // Distribute cards among people
    $result = [];
    $startIndex = 0;
    for ($i = 0; $i < $numPeople; $i++) {
        $chunkSize = $cardsPerPerson + ($i < $remainingCards ? 1 : 0);
        $result[] = array_slice($deck, $startIndex, $chunkSize);
        $startIndex += $chunkSize;
    }

    return $result;
}


// Test the function with a sample input (e.g., 5 people)
if(isset($_GET['numPeople'])) {
    // Retrieve the value of numPeople parameter
    $numPeople = $_GET['numPeople'];

    // Call your distributeCards function or logic here
    $result = distributeCards($numPeople);
    // Return the result as JSON
    echo json_encode($result);
} else {
    // If numPeople parameter is not provided in the URL, display an error message
    echo json_encode(["error" => "Number of people parameter (numPeople) is missing"]);
}
?>
