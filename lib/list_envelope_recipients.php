<?php

    class ListEnvelopeRecipients extends ExampleBase {
        public function __construct($client) {
            parent::__construct($client);
        }

        public function list($envelopeId){
            if(is_null($envelopeId))
                throw new InvalidArgumentException("PROBLEM: This example software doesn't know which envelope's " +
                        "information should be looked up.\n" +
                        "SOLUTION: First run the <b>Send Envelope via email</b> example to create an envelope.");

            $this->validateToken();

            $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi(self::$apiClient);

            return $envelopeApi->listRecipients(self::$accountID, $envelopeId);
        }
    }
?>