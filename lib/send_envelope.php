<?php
include_once 'example_base.php';

class SendEnvelope extends ExampleBase {
    const DEMO_DIR = "demo_documents";
    const DOC_2_DOCX = "World_Wide_Corp_Battle_Plan_Trafalgar.docx";
    const DOC_3_PDF = "World_Wide_Corp_lorem.pdf";

    private static function DOCUMENT_1() {
        $signer_name = DSConfig::signer_name();
        $signer_email = DSConfig::signer_email();
        $cc_name = DSConfig::cc_name();
        $cc_email = DSConfig::cc_email();

        return <<<HTML
        <!DOCTYPE html>
            <html>
                <head>
                  <meta charset='UTF-8'>
                </head>
                <body style='font-family:sans-serif;margin-left:2em;'>
                <h1 style='font-family: "Trebuchet MS", Helvetica, sans-serif;
                     color: darkblue;margin-bottom: 0;'>World Wide Corp</h1>
                <h2 style='font-family: "Trebuchet MS", Helvetica, sans-serif;
                     margin-top: 0px;margin-bottom: 3.5em;font-size: 1em;
                     color: darkblue;'>Order Processing Division</h2>
              <h4>Ordered by {$signer_name}</h4>
                <p style='margin-top:0em; margin-bottom:0em;'>Email: {$signer_email}</p>
                <p style='margin-top:0em; margin-bottom:0em;'>Copy to: {$cc_name}, {$cc_email}</p>
                <p style='margin-top:3em;'>
              Candy bonbon pastry jujubes lollipop wafer biscuit biscuit. Topping brownie sesame snaps
             sweet roll pie. Croissant danish biscuit soufflé caramels jujubes jelly. Dragée danish caramels lemon
             drops dragée. Gummi bears cupcake biscuit tiramisu sugar plum pastry.
             Dragée gummies applicake pudding liquorice. Donut jujubes oat cake jelly-o. Dessert bear claw chocolate
             cake gummies lollipop sugar plum ice cream gummies cheesecake.
                </p>
                <!-- Note the anchor tag for the signature field is in white. -->
                <h3 style='margin-top:3em;'>Agreed: <span style='color:white;'>**signature_1**/</span></h3>
                </body>
            </html>
HTML;
    }

    public function __construct($client) {
        parent::__construct($client);
    }

    public function send() {
        $this->checkToken();
        $envelope = new DocuSign\eSign\Model\EnvelopeDefinition();
        $envelope->setEmailSubject("Please sign this document sent from PHP SDK");
        $doc1 = new DocuSign\eSign\Model\Document();
        $doc1->setDocumentBase64(base64_encode(self::DOCUMENT_1()));
        $doc1->setName("Order acknowledgement");
        $doc1->setFileExtension("html");
        $doc1->setDocumentId("1");
        $doc2 = new DocuSign\eSign\Model\Document();
        $doc2->setDocumentBase64(base64_encode(DSHelper::readContent(
            join(DIRECTORY_SEPARATOR,array(getcwd(), self::DEMO_DIR,
            self::DOC_2_DOCX)))));
        $doc2->setName("Battle Plan");
        $doc2->setFileExtension("docx");
        $doc2->setDocumentId("2");
        $doc3 = new DocuSign\eSign\Model\Document();
        $doc3->setDocumentBase64(base64_encode(DSHelper::readContent(
          join(DIRECTORY_SEPARATOR,array(getcwd(), self::DEMO_DIR,
            self::DOC_3_PDF)))));
        $doc3->setName("Lorem Ipsum");
        $doc3->setFileExtension("pdf");
        $doc3->setDocumentId("3");
        // The order in the docs array determines the order in the envelope
        $envelope->setDocuments(array($doc1, $doc2, $doc3));

        // create a signer recipient to sign the document, identified by name and email
        // We're setting the parameters via the object creation
        $signer1 = new DocuSign\eSign\Model\Signer();
        $signer1->setEmail(DSConfig::signer_email());
        $signer1->setName(DSConfig::signer_name());
        $signer1->setRecipientId("1");
        $signer1->setRoutingOrder("1");
        // routingOrder (lower means earlier) determines the order of deliveries
        // to the recipients. Parallel routing order is supported by using the
        // same integer as the order for two or more recipients.

        // create a cc recipient to receive a copy of the documents, identified by name and email
        // We're setting the parameters via setters
        $cc1 = new DocuSign\eSign\Model\CarbonCopy();
        $cc1->setEmail(DSConfig::cc_email());
        $cc1->setName(DSConfig::cc_name());
        $cc1->setRoutingOrder("2");
        $cc1->setRecipientId("2");
        // Create signHere fields (also known as tabs) on the documents,
        // We're using anchor (autoPlace) positioning
        //
        // The DocuSign platform seaches throughout your envelope's
        // documents for matching anchor strings. So the
        // sign_here_2 tab will be used in both document 2 and 3 since they
        // use the same anchor string for their "signer 1" tabs.
        $signHere1 = new DocuSign\eSign\Model\SignHere();
        $signHere1->setAnchorString("**signature_1**");
        $signHere1->setAnchorUnits("pixels");
        $signHere1->setAnchorXOffset("20");
        $signHere1->setAnchorYOffset("10");

        $signHere2 = new DocuSign\eSign\Model\SignHere();
        $signHere2->setAnchorString("/sn1/");
        $signHere2->setAnchorUnits("pixels");
        $signHere2->setAnchorXOffset("20");
        $signHere2->setAnchorYOffset("10");
        // Tabs are set per recipient / signer
        $tabs = new DocuSign\eSign\Model\Tabs();
        $tabs->setSignHereTabs(array($signHere1, $signHere2));
        $signer1->setTabs($tabs);
        // Add the recipients to the envelope object
        $recipients = new DocuSign\eSign\Model\Recipients();
        $recipients->setSigners(array($signer1));
        $recipients->setCarbonCopies(array($cc1));
        $envelope->setRecipients($recipients);
        // Request that the envelope be sent by setting |status| to "sent".
        // To request that the envelope be created as a draft, set to "created"
        $envelope->setStatus("sent");

        $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi(self::$apiClient);
        $results = $envelopeApi->createEnvelope(self::$accountID, $envelope);

        return $results;
    }
}
