# HNG12 Stage 1 Task - Number Classification API

This is a simple backend API developed for the HNG12 Stage 1 Task. The API takes a number as input and returns interesting mathematical properties about it, along with a fun fact from the Numbers API.

## Technology Stack

- **Programming Language**: PHP

---

## API Specification

### Endpoint
- **Method**: GET
- **URL**: https://hng12-number-classification-api.onrender.com/api/classify-number.php?number=371

### Response Format: JSON

#### **Success Response (200 OK)**
```json
{
  "number": 371,
  "is_prime": false,
  "is_perfect": false,
  "properties": ["armstrong", "odd"],
  "digit_sum": 11,
  "fun_fact": "371 is an Armstrong number because 3^3 + 7^3 + 1^3 = 371"
}
```

#### **Error Response (400 Bad Request)**
```json
{
  "number": "abc",
  "error": true
}
```

---

## Setup Instructions

### Prerequisites
- Ensure you have **PHP** installed (version 8.2+).

### Installation
1. **Clone the repository**:
   ```bash
   git clone https://github.com/imjolayemi/HNG12_Number_Classification_API.git
   cd HNG12_Number_Classification_API
   ```
2. **Run the application**:
   - Start a PHP development server:
     ```bash
     php -S 0.0.0.0:8000 index.php
     ```
   - The API should now be accessible at:
     ```
     http://localhost:8000/api/classify-number?number=371
     ```

---

## Deployment

The API is deployed and publicly accessible at:
- https://hng12-number-classification-api.onrender.com/api/classify-number.php?number=371

---

## CORS Handling

The API is configured to handle Cross-Origin Resource Sharing (CORS) properly by setting the appropriate headers in the PHP code:
```php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
```

---

## Useful Links

- PHP Developers:  https://hng.tech/hire/php-developers

---

## Author

**Jolayemi**

- **GitHub**: [imjolayemi](https://github.com/imjolayemi) 


# STEP BY STEP EXPLANATION OF THE API CODE

# Number Classification API - PHP (No Framework)

## **Overview**
This PHP script implements the **Number Classification API** to return various mathematical properties of a given number, including whether it is **prime, perfect, or an Armstrong number**, along with a **math fun fact** from the Numbers API.

---

## **Code Explanation (Step by Step)**

### **1. Setting HTTP Headers**
```php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
```
- `Access-Control-Allow-Origin: *` → Allows API requests from any domain (**CORS handling**).
- `Content-Type: application/json` → Ensures the response is returned in **JSON format**.

---

### **2. Prime Number Check Function**
```php
function is_prime($num) {
    if ($num < 2) return false;
    for ($i = 2; $i * $i <= $num; $i++) {
        if ($num % $i === 0) return false;
    }
    return true;
}
```
- Checks if the given number is **prime** (divisible only by 1 and itself).

---

### **3. Perfect Number Check Function**
```php
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
```
- **Perfect numbers** are numbers where the sum of their divisors (excluding themselves) equals the number.

---

### **4. Armstrong Number Check Function**
```php
function is_armstrong($num) {
    $sum = 0;
    $digits = str_split($num);
    $power = count($digits);
    foreach ($digits as $digit) {
        $sum += pow((int)$digit, $power);
    }
    return $sum == $num;
}
```
- **Armstrong numbers** are numbers where the sum of their digits raised to the power of the total number of digits equals the number itself.

---

### **5. Fetching a Math Fun Fact**
```php
function get_fun_fact($num) {
    $api_url = "http://numbersapi.com/{$num}/math?json";
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);
    return $data['text'] ?? "No fact available.";
}
```
- Calls the **Numbers API** (`math` type) to retrieve a **math fun fact** about the number.
- Converts the API response from **JSON to an associative array**.
- Returns the `"text"` field or a default message if not available.

---

### **6. Validating Input**
```php
if (!isset($_GET['number']) || !is_numeric($_GET['number'])) {
    echo json_encode(["number" => $_GET['number'] ?? null, "error" => true]);
    exit;
}
```
- Checks if the `number` parameter **exists** and is a **valid integer**.
- Returns a **JSON error response** if the input is invalid.

---

### **7. Processing the Number**
```php
$number = (int) $_GET['number'];
$digit_sum = array_sum(str_split($number));
$is_prime = is_prime($number);
$is_perfect = is_perfect($number);
$is_armstrong = is_armstrong($number);
$properties = [$is_armstrong ? "armstrong" : null, $number % 2 === 0 ? "even" : "odd"];
$properties = array_filter($properties);
```
- Converts the input to an **integer**.
- **Calculates**:
  - Sum of digits → `digit_sum`
  - If it's **prime**, **perfect**, or **Armstrong**.
- **Determines properties**:
  - If Armstrong → `"armstrong"`.
  - If even → `"even"`.
  - Otherwise → `"odd"`.
- Uses `array_filter()` to **remove null values**.

---

### **8. Fetching the Fun Fact**
```php
$fun_fact = get_fun_fact($number);
```
- Calls the function to get a **math fun fact** from the **Numbers API**.

---

### **9. Preparing JSON Response**
```php
$response = [
    "number" => $number,
    "is_prime" => $is_prime,
    "is_perfect" => $is_perfect,
    "properties" => $properties,
    "digit_sum" => $digit_sum,
    "fun_fact" => $fun_fact
];
```
- **Creates an associative array** containing:
  - The number itself
  - Whether it's **prime**, **perfect**, **Armstrong**
  - The **digit sum**
  - The **math fun fact**

---

### **10. Returning JSON Response**
```php
echo json_encode($response, JSON_PRETTY_PRINT);
```
- Converts the **response array to a JSON string**.
- `JSON_PRETTY_PRINT` makes it **formatted for readability**.

---

## **✅ Example API Calls**

### **Example 1: Valid Input (`number=371`)**
#### **Request**
```sh
GET /api/classify-number?number=371
```
#### **Response**
```json
{
    "number": 371,
    "is_prime": false,
    "is_perfect": false,
    "properties": ["armstrong", "odd"],
    "digit_sum": 11,
    "fun_fact": "371 is an Armstrong number because 3^3 + 7^3 + 1^3 = 371."
}
```

### **Example 2: Invalid Input (`number=abc`)**
#### **Request**
```sh
GET /api/classify-number?number=abc
```
#### **Response**
```json
{
    "number": "abc",
    "error": true
}
```

---

## **🔹 Summary**
This script:
✔️ Accepts **GET requests** with a `number` parameter  
✔️ Returns **mathematical properties** (prime, perfect, Armstrong)  
✔️ Computes the **sum of digits**  
✔️ Fetches a **math fun fact** from **Numbers API**  
✔️ Handles **error responses** correctly  
✔️ Returns **JSON output**  

---

## **📌 Deployment**
To deploy:
1. Save this file as `index.php`.
2. Upload to a **PHP hosting server** (e.g., Render, Vercel, or a VPS).
3. Ensure **CORS is enabled**.

Your **HNG12 Number Classification API** is **fully functional**! 🚀  
Let me know if you have **questions or need improvements**. 🎯

