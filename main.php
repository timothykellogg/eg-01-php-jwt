<?php
    require_once('vendor/autoload.php');
    require_once('vendor/docusign/esign-client/autoload.php');
    include_once 'ds_config.php';
    include_once 'lib/example_base.php';
    include_once 'lib/send_envelope.php';
    include_once 'lib/list_envelopes.php';
    $config = new DocuSign\eSign\Configuration();
    $apiClient = new DocuSign\eSign\ApiClient($config);

    try {
        print("\nSending an envelope...\n");
        $sendHandler = new SendEnvelope($apiClient);
        $result = $sendHandler->send();

        printf("\nEnvelope status: %s. Envelope ID: %s\n", $result->getStatus(), $result->getEnvelopeId());

        print("\nList envelopes in the account...");
        $listEnvelopesHandler= new ListEnvelopes($apiClient);
        $envelopesList = $listEnvelopesHandler->listEnvelopes();
        $envelopes = $envelopesList->getEnvelopes();

        if(!is_null($envelopesList)  && count($envelopes) > 2) {
            printf("\nResults for %d envelopes were returned. Showing the first two:\n", count($envelopes));
            $envelopesList->setEnvelopes(array($envelopes[0],$envelopes[1]));
        } else {
            printf("\nResults for %d envelopes were returned:\n", count($envelopes));
        }
        # $envelopesList is an object that implements ArrayAccess. Convert to a regular array:
        $results = json_decode((string)$envelopesList, true);
        # pretty print it:
        print (json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    } catch (Exception $e) {
        print ("\n\nException!\n");
        print ($e->getMessage());

        if ($e instanceof DocuSign\eSign\ApiException) {
            print ("\nAPI error information: \n");
            print ($e->getResponseObject());
        }


    }

    print("\nDone.\n");

