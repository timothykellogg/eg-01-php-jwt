<?php
   class DSConfig {
        private $config;
        private static $instance;

        private static function getInstance() {
            if(is_null(self::$instance)){
                self::$instance = new DSConfig();
            }

            return self::$instance;
        }

        private static function loadFromEnv() {
            $clientId = getenv("DS_CLIENT_ID");

            if (!is_null($clientId) and !empty($clientId)) {
                return $_ENV;
            }
            return null;
        }

        public function __construct() {
            $this->$config = self::loadFromEnv();
            if(is_null($this->$config)) {
                $this->$config = parse_ini_file('config.ini', true);
            }
        }

        private function _client_id() {
            return $this->$config["DS_CLIENT_ID"];
        }
        public static  function client_id() {
            return self::getInstance()->_client_id();
        }
        private function _impersonated_user_guid() {
            return $this->$config["DS_IMPERSONATED_USER_GUID"];
        }
        public static  function impersonated_user_guid() {
            return self::getInstance()->_impersonated_user_guid();
        }
        private function _target_account_id() {
            return $this->$config["DS_TARGET_ACCOUNT_ID"];
        }
        public static  function target_account_id(){
            return self::getInstance()->_target_account_id();
        }
        public static  function oauth_redirect_uri(){
            return "https://www.docusign.com";
        }
        private function _signer_email() {
            return $this->$config["DS_SIGNER_1_EMAIL"];
        }
        public static  function signer_email(){
            return self::getInstance()->_signer_email();
        }
        private function _signer_name(){
            return $this->$config["DS_SIGNER_1_NAME"];
        }
        public static  function signer_name(){
            return self::getInstance()->_signer_name();
        }
        private function _cc_email() {
            return $this->$config["DS_CC_1_EMAIL"];
        }
        public static function cc_email(){
            return self::getInstance()->_cc_email();
        }
        private function _cc_name(){
            return $this->$config["DS_CC_1_NAME"];
        }
        public static function cc_name(){
            return self::getInstance()->_cc_name();
        }
        private function _private_key_file(){
            return $this->$config["DS_PRIVATE_KEY_FILE"];
        }
        public static function private_key_file(){
            return self::getInstance()->_private_key_file();
        }
        private function _private_key() {
            return $this->$config["DS_PRIVATE_KEY"];
        }
        public static function private_key(){
            return self::getInstance()->_private_key();
        }
        public static function authentication_url() {
            return "https://account-d.docusign.com";
        }
        public static function aud() {
            return "account-d.docusign.com";
        }
        public static function api() {
            return "restapi/v2";
        }
        public static function permission_scopes() {
            return "signature impersonation";
        }
        public static function jwt_scope() {
             return "signature";
        }
   }
?>