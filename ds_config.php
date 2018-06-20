<?php
   class DSConfig {

        public static  function client_id() {
            return self::$config["DS_CLIENT_ID"];
        }
        public static  function impersonated_user_guid() {
            return self::$config["DS_IMPERSONATED_USER_GUID"];
        }
        public static  function target_account_id(){
            return self::$config["DS_TARGET_ACCOUNT_ID"];
        }
        public static  function oauth_redirect_uri(){
            return "https://www.docusign.com";
        }
        public static  function signer_email(){
            return self::$config["DS_SIGNER_1_EMAIL"];
        }
        public static  function signer_name(){
            return self::$config["DS_SIGNER_1_NAME"];
        }
        public static  function cc_email(){
            return self::$config["DS_CC_1_EMAIL"];
        }
        public static  function cc_name(){
            return self::$config["DS_CC_1_NAME"];
        }
        public static  function private_key_file(){
            return self::$config["DS_PRIVATE_KEY_FILE"];
        }
        public static  function private_key(){
            return self::$config["DS_PRIVATE_KEY"];
        }
        public static  function authentication_url() {
            return "https://account-d.docusign.com";
        }
        public static  function aud() {
            return "account-d.docusign.com";
        }
        public static  function api() {
            return "restapi/v2";
        }
        public static  function permission_scopes() {
            return "signature impersonation";
        }
        public static  function jwt_scope() {
             return "signature";
        }
        private static $config;

        public function __construct(){
            print "reading configuration...\n";
            self::$config = parse_ini_file('config.ini', true);
        }
   }
?>