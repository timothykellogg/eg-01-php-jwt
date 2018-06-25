<?php
    require_once('vendor/docusign/esign-client/autoload.php');
    include_once 'example_base.php';

    class GetEnvelopeStatus extends ExampleBase {
        public function __construct($client) {
            parent::__construct($client);
        }

        public function getEnvelope($envelopeId) {

            if(is_null($envelopeId))
                throw new InvalidArgumentException(
                        "PROBLEM: This example software doesn't know which envelope's
                        information should be looked up.
                        SOLUTION: First run the <b>Send Envelope via email</b> example to create an envelope.");

            $this->validateToken();

            // call the getEnvelope() API
            $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi(self::$apiClient);

            return $envelopeApi->getEnvelope(self::$accountID, $envelopeId);
        }
    }
?>