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
    $envelopesList = $listEnvelopesHandler->list();

    $envelopes = $envelopesList->getEnvelopes();

    if(!is_null($envelopesList)  && count($envelopes) > 2) {
        printf("\nResults for %d envelopes were returned. Showing the first two:", count($envelopes));
        $envelopesList->setEnvelopes(array($envelopes[0],$envelopes[1]));
    }

    $firstEnvelopeId;
    // Save an envelopeId for later use if an envelope list was returned (result set could be empty)
    if(!is_null($envelopes) && !is_null($envelopes[0])){
        $firstEnvelopeId = $envelopes[0]->getEnvelopeId();
    }

    DSHelper::printPrettyJSON($envelopesList);

    print("\nGet an envelope's status...");
    $getEnvelopeStatusHandler = new GetEnvelopeStatus($apiClient);
    $envelope = $getEnvelopeStatusHandler->getEnvelope($firstEnvelopeId);
    DSHelper::printPrettyJSON($envelope);

    print("\nList an envelope's recipients and their status...");
    $ListEnvelopeRecipientsHandler = new ListEnvelopeRecipients($apiClient);
    $recipients = $ListEnvelopeRecipientsHandler->list($firstEnvelopeId);
    DSHelper::printPrettyJSON($recipients);

    print("\nDownload an envelope's document(s)...");
    $getEnvelopeDocumentsHandler = new GetEnvelopeDocuments($apiClient);
    $getEnvelopeDocumentsHandler->download($firstEnvelopeId);

    ?>