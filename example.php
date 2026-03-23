<?php

/**
 * Example usage of the IMEI GSX API PHP SDK
 */

require_once 'ImeiGsxClient.php';

use ImeiGsx\API\Client;

// 1. Initialize the client with your API Key
// Get your key at https://www.imeigsx.com
$apiKey = "YOUR_UNIQUE_API_KEY_HERE";
$api = new Client($apiKey);

try {
    // 2. Check Account Balance
    echo "--- Fetching Balance ---\n";
    $balanceInfo = $api->getBalance();
    echo "Username: " . $balanceInfo['username'] . "\n";
    echo "Balance: " . $balanceInfo['balance'] . " Credits\n";

    // 3. Request an Apple GSX Premium Report
    echo "\n--- Requesting GSX Premium Report ---\n";
    $imei = "356327109246188"; // Replace with real IMEI
    $report = $api->checkDevice("gsxpremium", $imei);
    
    if ($report['success']) {
        echo "Device: " . $report['device']['productDescription'] . "\n";
        echo "Purchase Country: " . $report['device']['purchaseCountry'] . "\n";
        echo "FMI Status: " . ($report['fmiStatus'] === 'true' ? 'ON' : 'OFF') . "\n";
        echo "MDM Status: " . $report['mdmStatus'] . "\n";
    } else {
        echo "Request failed: " . $report['message'] . "\n";
    }

} catch (Exception $e) {
    echo "Caught Exception: " . $e->getMessage() . "\n";
}