<?php
    require_once('vendor/docusign/esign-client/autoload.php');
    include_once 'example_base.php';

    class ListEnvelopes extends ExampleBase {
        public function __construct($client) {
            parent::__construct($client);
        }

        public function list(){
            $this->validateToken();
            $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi(self::$apiClient);

            $options = new DocuSign\eSign\Api\EnvelopesApi\ListStatusChangesOptions();
            $date = new Datetime();
            $date->sub(new DateInterval("P30D"));
            $options->setFromDate($date->format("Y/m/d"));
            return $envelopeApi->listStatusChanges(self::$accountID, $options);
        }
    }
?>