<?php
    require_once('vendor/docusign/esign-client/autoload.php');
    include_once 'ds_config.php';
    include_once 'example_base.php';
    include_once 'send_envelope.php';
    include_once 'list_envelopes.php';

    new DSConfig();

    // $host = "https://demo.docusign.net/restapi";
    $config = new DocuSign\eSign\Configuration();
    $apiClient = new DocuSign\eSign\ApiClient($config);

    print("\nSending and envelope...\n");
    $sendHandler = new SendEnvelope($apiClient);
    $result = $sendHandler->send();

    printf("\nEnvelope status: %s. Envelope ID: %s", $result->getStatus(), $result->getEnvelopeId());

    print("\nList envelopes in the account...");
    $listEnvelopesHandler= new ListEnvelopes($apiClient);
    $envelopesList = $listEnvelopesHandler->list();


    ?>