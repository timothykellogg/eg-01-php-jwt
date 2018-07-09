<?php
    require_once('vendor/autoload.php');
    require_once('vendor/docusign/esign-client/autoload.php');
    include_once 'ds_config.php';
    include_once 'lib/example_base.php';
    include_once 'lib/send_envelope.php';
    include_once 'lib/list_envelopes.php';
    include_once 'lib/get_envelope_status.php';
    include_once 'lib/list_envelope_recipients.php';
    include_once 'lib/get_envelope_documents.php';

    $config = new DocuSign\eSign\Configuration();
    $apiClient = new DocuSign\eSign\ApiClient($config);

    print("\nSending and envelope...\n");
    $sendHandler = new SendEnvelope($apiClient);
    $result = $sendHandler->send();

    printf("\nEnvelope status: %s. Envelope ID: %s", $result->getStatus(), $result->getEnvelopeId());

    print("\nList envelopes in the account...");
    $listEnvelopesHandler= new ListEnvelopes($apiClient);
    $listEnvelopesHandler->list();

    print("\nDone.")
    ?>