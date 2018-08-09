<?php
include_once 'example_base.php';

class SendEnvelope extends ExampleBase {
    const DEMO_DIR = "demo_documents";
    const DOC_2_DOCX = "World_Wide_Corp_Battle_Plan_Trafalgar.docx";
    const DOC_3_PDF = "World_Wide_Corp_lorem.pdf";

    private static function ENVELOPE_1_DOCUMENT_1() {
        return "<!DOCTYPE html>
            <html>
                <head>
                  <meta charset=\"UTF-8\">
                </head>
                <body style=\"font-family:sans-serif;margin-left:2em;\">
                <h1 style=\"font-family: 'Trebuchet MS', Helvetica, sans-serif;
                     color: darkblue;margin-bottom: 0;\">World Wide Corp</h1>
                <h2 style=\"font-family: 'Trebuchet MS', Helvetica, sans-serif;
                     margin-top: 0px;margin-bottom: 3.5em;font-size: 1em;
                     color: darkblue;\">Order Processing Division</h2>
              <h4>Ordered by ".DSConfig::signer_name() ."</h4>
                <p style=\"margin-top:0em; margin-bottom:0em;\">Email: ".DSConfig::signer_email()."</p>
                <p style=\"margin-top:0em; margin-bottom:0em;\">Copy to: ".DSConfig::cc_name().", ".DSConfig::signer_email()."</p>
                <p style=\"margin-top:3em;\">
              Candy bonbon pastry jujubes lollipop wafer biscuit biscuit. Topping brownie sesame snaps
             sweet roll pie. Croissant danish biscuit soufflé caramels jujubes jelly. Dragée danish caramels lemon
             drops dragée. Gummi bears cupcake biscuit tiramisu sugar plum pastry.
             Dragée gummies applicake pudding liquorice. Donut jujubes oat cake jelly-o. Dessert bear claw chocolate
             cake gummies lollipop sugar plum ice cream gummies cheesecake.
                </p>
                <!-- Note the anchor tag for the signature field is in white. -->
                <h3 style=\"margin-top:3em;\">Agreed: <span style=\"color:white;\">**signature_1**/</span></h3>
                </body>
            </html>";
    }

    public function __construct($client) {
        parent::__construct($client);
    }

    public function send() {
        $this->checkToken();
        $envelope = $this->createEnvelope();
        $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi(self::$apiClient);
        $results = $envelopeApi->createEnvelope(self::$accountID, $envelope);
        return $results;
    }

    private function createEnvelope(){
        $envelopeDefinition = new DocuSign\eSign\Model\EnvelopeDefinition();
        $envelopeDefinition->setEmailSubject("Please sign this document sent from PHP SDK");
        $doc1 = $this->createDocumentFromTemplate("1", "Order acknowledgement","html", self::ENVELOPE_1_DOCUMENT_1());
        $doc2 = $this->createDocumentFromTemplate("2","Battle Plan","docx",
                DSHelper::readContent(join(DIRECTORY_SEPARATOR,array(getcwd(), self::DEMO_DIR, self::DOC_2_DOCX))));
        $doc3 = $this->createDocumentFromTemplate("3","Lorem Ipsum","pdf",
                DSHelper::readContent(join(DIRECTORY_SEPARATOR,array(getcwd(), self::DEMO_DIR,self::DOC_3_PDF))));
        // The order in the docs array determines the order in the envelope
        $envelopeDefinition->setDocuments(array($doc1, $doc2, $doc3));
        // create a signer recipient to sign the document, identified by name and email
        // We're setting the parameters via the object creation
        $signer1 = $this->createSigner();
        // routingOrder (lower means earlier) determines the order of deliveries
        // to the recipients. Parallel routing order is supported by using the
        // same integer as the order for two or more recipients.

        // create a cc recipient to receive a copy of the documents, identified by name and email
        // We're setting the parameters via setters
        $cc1 = $this->createCarbonCopy();
        // Create signHere fields (also known as tabs) on the documents,
        // We're using anchor (autoPlace) positioning
        //
        // The DocuSign platform seaches throughout your envelope's
        // documents for matching anchor strings. So the
        // sign_here_2 tab will be used in both document 2 and 3 since they
        // use the same anchor string for their "signer 1" tabs.
        $signHere1 = $this->createSignHere("**signature_1**","pixels", "20","10");
        $signHere2 = $this->createSignHere("/sn1/","pixels", "20","10");
        // Tabs are set per recipient / signer
        $this->setSignerTabs($signer1, $signHere1, $signHere2);
        // Add the recipients to the envelope object
        $recipients = $this->createRecipients($signer1, $cc1);
        $envelopeDefinition->setRecipients($recipients);
        // Request that the envelope be sent by setting |status| to "sent".
        // To request that the envelope be created as a draft, set to "created"
        $envelopeDefinition->setStatus("sent");

        return $envelopeDefinition;
    }

    private function createDocumentFromTemplate($id, $name, $fileExtension, $content) {
        $document = new DocuSign\eSign\Model\Document();

        // $str=implode(array_map("chr", $content));
        $base64Content = base64_encode($content);
        // print($base64Content);
        $document->setDocumentBase64($base64Content);
        // can be different from actual file name
        $document->setName($name);
        // Source data format. Signed docs are always pdf.
        $document->setFileExtension($fileExtension);
        // a label used to reference the doc
        $document->setDocumentId($id);

        return $document;
    }

    private function createSigner(){
        $signer = new DocuSign\eSign\Model\Signer();
        $signer->setEmail(DSConfig::signer_email());
        $signer->setName(DSConfig::signer_name());
        $signer->setRecipientId("1");
        $signer->setRoutingOrder("1");
        return $signer;
    }

    private function createCarbonCopy(){
        $cc = new DocuSign\eSign\Model\CarbonCopy();
        $cc->setEmail(DSConfig::cc_email());
        $cc->setName(DSConfig::cc_name());
        $cc->setRoutingOrder("2");
        $cc->setRecipientId("2");
        return $cc;
    }

    private function createSignHere($anchorPattern, $anchorUnits, $anchorXOffset, $anchorYOffset) {
        $signHere = new DocuSign\eSign\Model\SignHere();
        $signHere->setAnchorString($anchorPattern);
        $signHere->setAnchorUnits($anchorUnits);
        $signHere->setAnchorXOffset($anchorXOffset);
        $signHere->setAnchorYOffset($anchorYOffset);
        return $signHere;
    }

    private function setSignerTabs() {
        $signer =  func_get_arg(0);
        $tabs = new DocuSign\eSign\Model\Tabs();
        $tabs->setSignHereTabs(array(func_get_arg(1), func_get_arg(2)));
        $signer->setTabs($tabs);
    }

    private function createRecipients($signer, $cc) {

        $recipients = new DocuSign\eSign\Model\Recipients();
        $recipients->setSigners(array($signer));
        $recipients->setCarbonCopies(array($cc));

        return $recipients;
    }
}
