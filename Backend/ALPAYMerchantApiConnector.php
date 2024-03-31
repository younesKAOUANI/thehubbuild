<?php

    namespace ALPAY\PHP\V1;

    class ALPAYPayment {
        private $apiKey;
        private $apiSecret;

        public function __construct($apiKey, $apiSecret) {
            $this->apiKey = $apiKey;
            $this->apiSecret = $apiSecret;
        }

        public function initiatePaymentOrder($payOrder) {
            $url = "https://api.alpay.io/v1/";

            $headers = array(
                "Token: " . (hash("sha256", $this->apiKey . $this->apiSecret)),
                "Src: 10012d40f9f920c466f095c39c6e45f2f1661ff6a858babd99978708704126b1",
                "Content-Type: application/json"
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payOrder));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            

            $decodedResponse = json_decode($response, true);
            $decodedResponse["authorized"] = false;

            if (is_array($decodedResponse) && isset($decodedResponse['checkoutUrl']) && filter_var($decodedResponse['checkoutUrl'], FILTER_VALIDATE_URL)) {
                $decodedResponse["authorized"] = true;
            }

            curl_close($ch);

            return ($decodedResponse);
        }
    }