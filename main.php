<?php
    require_once('vendor/autoload.php');
    require_once('vendor/docusign/esign-client/autoload.php');
    include_once 'ds_config.php';
    include_once 'lib/example_base.php';
    include_once 'lib/send_envelope.php';
    include_once 'lib/list_envelopes.php';
    $config = new DocuSign\eSign\Configuration();
    $apiClient = new DocuSign\eSign\ApiClient($config);

    print("\nSending an envelope...\n");
    $sendHandler = new SendEnvelope($apiClient);
    $result = $sendHandler->send();

    printf("\nEnvelope status: %s. Envelope ID: %s", $result->getStatus(), $result->getEnvelopeId());

    print("\nList envelopes in the account...");
    $listEnvelopesHandler= new ListEnvelopes($apiClient);
    //TODO: print the first 2 envelope like java,C# (how many there are )
    $envelopesList = $listEnvelopesHandler->list();
    $envelopes = $envelopesList->getEnvelopes();

    if(!is_null($envelopesList)  && count($envelopes) > 2) {
        printf("\nResults for %d envelopes were returned. Showing the first two:", count($envelopes));
        $envelopesList->setEnvelopes(array($envelopes[0],$envelopes[1]));
    }

    DSHelper::printPrettyJSON($envelopesList);
    print("\nDone.")
    ?>