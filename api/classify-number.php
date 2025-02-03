<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Function to check if a number is prime
function is_prime($num) {
    if ($num < 2) return false;
    for ($i = 2; $i * $i <= $num; $i++) {
        if ($num % $i === 0) return false;
    }
    return true;
}

// Function to check if a number is perfect
function is_perfect($num) {
    if ($num < 2) return false;
    $sum = 1;
    for ($i = 2; $i * $i <= $num; $i++) {
        if ($num % $i === 0) {
            $sum += $i;
            if ($i !== $num / $i) $sum += $num / $i;
        }
    }
    return $sum === $num;
}

// Function to check if a number is an Armstrong number
function is_armstrong($num) {
    $sum = 0;
    $digits = str_split($num);
    $power = count($digits);
    foreach ($digits as $digit) {
        $sum += pow((int)$digit, $power);
    }
    return $sum == $num;
}

// Function to get a math fun fact from Numbers API
function get_fun_fact($num) {
    $api_url = "http://numbersapi.com/{$num}/math?json";
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    return $data['text'] ?? "No fact available.";
}

// Validate input
if (!isset($_GET['number']) || !is_numeric($_GET['number'])) {
    echo json_encode(["number" => $_GET['number'] ?? null, "error" => true]);
    exit;
}

$number = (int) $_GET['number'];
$digit_sum = array_sum(str_split($number));
$is_prime = is_prime($number);
$is_perfect = is_perfect($number);
$is_armstrong = is_armstrong($number);
$properties = [$is_armstrong ? "armstrong" : null, $number % 2 === 0 ? "even" : "odd"];
$properties = array_filter($properties); // Remove null values

// Fetch the fun fact
$fun_fact = get_fun_fact($number);

// Prepare JSON response
$response = [
    "number" => $number,
    "is_prime" => $is_prime,
    "is_perfect" => $is_perfect,
    "properties" => $properties,
    "digit_sum" => $digit_sum,
    "fun_fact" => $fun_fact
];

// Return JSON response
echo json_encode($response, JSON_PRETTY_PRINT);
?>
