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

