<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Allow CORS

// Function to check if a number is prime
function is_prime($num) {
    if ($num < 2) return false;
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) return false;
    }
    return true;
}

// Function to check if a number is an Armstrong number
function is_armstrong($num) {
    $digits = str_split($num);
    $power = count($digits);
    $sum = array_sum(array_map(fn($digit) => pow($digit, $power), $digits));
    return $sum == $num;
}

// Function to get the sum of digits
function digit_sum($num) {
    return array_sum(str_split($num));
}

// Function to get a fun fact from the Numbers API
function get_fun_fact($num) {
    $url = "http://numbersapi.com/$num?json";
    $response = @file_get_contents($url);
    if ($response === FALSE) return "No fun fact available.";
    $data = json_decode($response, true);
    return $data["text"] ?? "No fun fact available.";
}

// Handle API Request
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["number"])) {
    $number = $_GET["number"];

    // Validate input (must be an integer)
    if (!is_numeric($number) || strpos($number, ".") !== false) {
        echo json_encode(["number" => $number, "error" => true]);
        http_response_code(400);
        exit;
    }

    $number = (int)$number;
    $isPrime = is_prime($number);
    $isArmstrong = is_armstrong($number);
    $digitSum = digit_sum($number);
    $funFact = get_fun_fact($number);

    // Determine properties
    $properties = [];
    if ($isArmstrong) $properties[] = "armstrong";
    $properties[] = ($number % 2 === 0) ? "even" : "odd";

    // JSON Response
    $result = [
        "number" => $number,
        "is_prime" => $isPrime,
        "is_perfect" => false, // Perfect number logic can be added if needed
        "properties" => $properties,
        "digit_sum" => $digitSum,
        "fun_fact" => $funFact
    ];

    echo json_encode($result);
    http_response_code(200);
    exit;
}

// Invalid request
echo json_encode(["error" => "Invalid request"]);
http_response_code(400);
exit;

?>