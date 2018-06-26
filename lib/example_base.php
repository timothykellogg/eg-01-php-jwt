<?php
require_once('vendor/docusign/esign-client/autoload.php');
require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;
include_once 'ds_config.php';
include_once 'ds_helper.php';
class ExampleBase {

   private $token;
   private $exp = 3600;

   private $permission_scopes="signature%20impersonation";
   private $redirect_uri ="https://docusign.com";

   protected static $expires_in;
   protected static $access_token;
   protected static $accountID;
   protected static $apiClient;

   public function __construct($client) {
       self::$apiClient = $client;
    }

    protected function validateToken() {
        if(is_null($token)){
            $this->updateToken();
        }
    }
    private function updateToken(){
        $this->authToken = $this->configureJwtAuthorizationFlowByKey();
        $a = $this->getUserInfo();
        self::$accountID = $a->{'account_id'};
    }
    /**
     *
     */
    private function configureJwtAuthorizationFlowByKey() {
        $current_time = time ();
        $aud = DSConfig::aud();
        $iss = DSConfig::client_id();

        $_token = array(
            "iss" => $iss,
            "sub" => DSConfig::impersonated_user_guid(),
            "aud" => $aud,
            "scope" => DSConfig::jwt_scope(),
            "nbf" => $current_time,
            "exp" => $current_time + $exp*1000
        );

        $private_key = DSConfig::private_key();

        $jwt  = JWT::encode($_token, $private_key, 'RS256');

        // printf ("Requesting an access token by using a JWT token...");
        $headers = array('Accept' => 'application/json');
        $data = array('grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $jwt);
        $body = Unirest\Request\Body::form($data);
        $response = Unirest\Request::post("https://{$aud}/oauth/token", $headers, $body);
        // Handle the response if it is an html page
        if (strpos($response->raw_body, '<html>') !== false) {
            throw new Exception("An error response was received!\n\n");
        }

        $json = $response->body;
        if (property_exists ($json, 'error') and $json->{'error'} == 'consent_required' ){
            $consent_url = "https://{$aud}/oauth/auth?response_type=code&scope={$this->permission_scopes}&client_id={$iss}&redirect_uri={$this->redirect_uri}";
            throw new Exception("\n\nC O N S E N T   R E Q U I R E D\n"
            ."Ask the user who will be impersonated to run the following url:\n"
            ."    {$consent_url}\n"
            ."It will ask the user to login and to approve access by your application.\n\n");
        }

        if (property_exists ($json, 'error') or !property_exists ($json, 'access_token')){
            throw new Exception("\n\nUnexpected error: {$json->{'error'}}\n\n");
        }

        self::$access_token = $json->{'access_token'};
        self::$expires_in = $json->{'expires_in'};

        $config = self::$apiClient->getConfig();
        $config->setAccessToken(self::$access_token);
        $config->addDefaultHeader('Authorization' , "Bearer {self::$access_token}");

        # Do this later, after getUserInfo: $config->setHost("https://demo.docusign.net/restapi");
    }

    private function getUserInfo(){
        $aud = DSConfig::aud();
        $access_token = self::$access_token;
        $user_info_url="https://{$aud}/oauth/userinfo";
        $headers = array('Accept' => 'application/json', 'Authorization' => "Bearer {$access_token}");
        $response = Unirest\Request::get($user_info_url, $headers);
        //TODO: replace with callApi
        // $response = self::$apiClient->callApi(
        //     $user_info_url,
        //     "GET",
        //     null,
        //     null,
        //     $headers
        // );
        $json = $response->body;
        $target = DSConfig::target_account_id();
        $accounts = $json->{'accounts'};

        if(is_null($target) or empty($target) or $target === "FALSE"){
            foreach($accounts as $acct){
                if($acct->{'is_default'} === true) {
                    return $acct;
                }
            }
        }

        foreach($account as $acct){
            if($acct->{'account_id'} === $target){
                return $acct;
            }
        }
    }
}

?>
