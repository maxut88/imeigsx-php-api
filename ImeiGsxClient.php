<?php

namespace ImeiGsx\API;

use Exception;

/**
 * Official PHP SDK for IMEI GSX API (imeigsx.com)
 * Provides high-speed access to IMEI checking, Apple GSX Reports, and iCloud status.
 *
 * @version 1.0.0
 * @link https://www.imeigsx.com
 */
class Client
{
    private $apiKey;
    private $baseUrl = 'https://www.imeigsx.com/api/v1/check';

    /**
     * Initialize the API Client
     * @param string $apiKey Your unique API Key from the client panel
     */
    public function __construct($apiKey)
    {
        if (empty($apiKey)) {
            throw new Exception("API Key is required. Get one at https://www.imeigsx.com/register.php");
        }
        $this->apiKey = $apiKey;
    }

    /**
     * Check Device Information (GSX, Find My, SimLock, etc.)
     * @param string $command The service command (e.g., 'gsxpremium', 'findmy', 'simlock')
     * @param string $identifier The IMEI (15 digits) or Serial Number
     * @return array JSON decoded response
     */
    public function checkDevice($command, $identifier)
    {
        $payload = [
            'command' => $command,
            'identifier' => $identifier
        ];

        return $this->makeRequest('POST', '/check', $payload);
    }

    /**
     * Retrieve current account balance and active pricing
     * @return array JSON decoded response
     */
    public function getBalance()
    {
        return $this->makeRequest('GET', '/balance');
    }

    /**
     * Internal method to handle cURL requests
     */
    private function makeRequest($method, $endpoint, $data = [])
    {
        $ch = curl_init();
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'X-API-Key: ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_USERAGENT => 'ImeiGsx-PHP-SDK/1.0'
        ];

        if ($method === 'POST' && !empty($data)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error) {
            throw new Exception("cURL Error: " . $error);
        }

        $decodedResponse = json_decode($response, true);

        if ($httpCode >= 400) {
            $errorMessage = isset($decodedResponse['message']) ? $decodedResponse['message'] : 'Unknown API Error';
            throw new Exception("API Error ({$httpCode}): " . $errorMessage);
        }

        return $decodedResponse;
    }
}