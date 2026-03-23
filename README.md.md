# 🚀 IMEI GSX API - Official PHP SDK

[![API Version](https://img.shields.io/badge/API-v1.0-blue.svg)](https://www.imeigsx.com)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.4-8a2be2.svg)]()
[![License](https://img.shields.io/badge/License-MIT-green.svg)]()

Welcome to the official PHP library for the [IMEI GSX API](https://www.imeigsx.com). This SDK provides a simple, object-oriented way to integrate high-speed device verification into your website, CRM, or specialized GSM panel.

## 🌟 Key Capabilities
* **Apple GSX Premium:** Direct access to Apple's official database (repair history, purchase data).
* **iCloud Status:** Real-time Find My iPhone (FMI) ON/OFF and Lost/Clean status.
* **Carrier Sim-Lock:** Deep carrier network checks and Next Tether Policy detection.
* **MDM Check:** Verify if a device is enrolled in corporate Management Profiles.
* **Serial Conversion:** Instant conversion from Serial Number (SN) to IMEI/IMEI2.

---

## 🛠️ Quick Start

### 1. Registration
Register at **[imeigsx.com](https://www.imeigsx.com/register.php)** to obtain your unique `API Key`.

### 2. Basic Implementation
Include the client class and start making requests:

```php
require_once 'ImeiGsxClient.php';
use ImeiGsx\API\Client;

$api = new Client("YOUR_API_KEY");

try {
    // Check Apple GSX Premium Report
    $result = $api->checkDevice("gsxpremium", "356327109246188");
    print_r($result);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}