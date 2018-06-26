<?php

require_once('vendor/docusign/esign-client/autoload.php');
include_once 'example_base.php';

class GetEnvelopeDocuments extends ExampleBase {
    public function __construct($client) {
        parent::__construct($client);
    }

    public function download($envelopeId) {
        if(is_null($envelopeId))
            throw new InvalidArgumentException(
                    "PROBLEM: This example software doesn't know which envelope's
                    information should be looked up.
                    SOLUTION: First run the <b>Send Envelope via email</b> example to create an envelope.");

        $this->validateToken();

        // The workflow will be multiple API requests:
        //  1) list the envelope's documents
        //  2) Loop to get each document
        $envelopeApi = new DocuSign\eSign\Api\EnvelopesApi(self::$apiClient);
        $docDownloadDirPath = DSHelper::ensureDirExistance("downloaded_documents");
        $documents = $envelopeApi->listDocuments(self::$accountID, $envelopeId);
        DSHelper::printPrettyJSON($documents);

        $envelopeDocuments = $documents->getEnvelopeDocuments();
        printf("Download files path: %s", $docDownloadDirPath);
        foreach($envelopeDocuments as $doc){
            $docName = $envelopeId."__".$doc->getName();
            $hasPDFsuffix = DSHelper::endsWith(strtoupper($docName), ".PDF");

            if(("content" === $doc->getType() || "summary" === $doc->getType()) && !$hasPDFsuffix) {
                $docName .=".pdf";
            }

            $docBytes = $envelopeApi->getDocument(self::$accountID, $doc->getDocumentId() ,$envelopeId);
            $filePath = join(DIRECTORY_SEPARATOR, array($docDownloadDirPath,$docName));
            DSHelper::writeByteArrayToFile($filePath, $docBytes);

            printf("\nWrote document id %s to %s", $doc->getDocumentId(), $docName);
        }
    }
}

?>