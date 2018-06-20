<?php

class ExampleBase {

   protected $apiClient;

   public function __construct($client) {
       $this->$apiClient = $client;
    }
}

?>