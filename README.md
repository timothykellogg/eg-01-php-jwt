# Example 1: PHP Service Integration

Repository: [eg-01-php-jwt](https://github.com/docusign/eg-01-php-jwt)

<!--
## Articles and Screencasts

* Guide: Using OAuth JWT flow with DocuSign.
* Screencast: Using OAuth JWT flow with DocuSign.
* Guide: Sending an envelope with the Node.JS SDK.
* Screencast: Sending an example with Node.JS SDK.
-->

## Introduction

This code example acts as a **System Integration**.

The application uses the OAuth JWT grant flow to impersonate
a user in the account.

This type of application interacts with DocuSign on its
own. There is no user interface and no user is present
during normal operation.

This launcher example includes two workflow examples:
1. Send an html, Word, and PDF file in an envelope to be signed.
1. List the envelopes in the account whose status has changed in the last 30 days old.

## Installation

Requirements: PHP v5.4 or later

Download or clone this repository. Then:

````
cd eg-01-php-jwt
composer install
````
Then configure the ds_config.ini config file.

### Configure the example's settings

Configuring the ds_config.ini file:

#### Creating the Integration Key
Your DocuSign Integration Key must be configured for a JWT OAuth authentication flow:
* Create a public/private key pair for the key. Store the private key
  in a secure location. You can use a file or a key vault.
* The example requires the private key. Store the private key in the
  `ds_config.ini` file.
  
  In the ds_config.ini file, add the private key, including the 
  BEGIN / END lines with a pair of quotation marks. Example:

````  
DS_PRIVATE_KEY="-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAkbz3bi31zrH2ry4p8S4ncPoMdkUyu+MG46m9BalOKzWNNAvW
1LVs5ftlXxzA6V0m6nx895w8S761/qZ8xtAAl99DezRn/3CueeBUyw+tvlmEBu1C
....
UC1WqwKBgQCY/6aZxlWX9XYgsQsnUjhj2aTwr7pCiQuYceIzLTQzy+nz8M4PfCE1
rjRsm6YTpoxh7nuW2qnFfMA58UPs9tonN/z1pr9mKfwmamtPXeMSJeEZUVmh7mNx
PEHgznlGh/vUboCuA4tQOcKytxFfKG4F+jM/g4GH9z46KZOow3Hb6g==
-----END RSA PRIVATE KEY-----"  
````  
  
* If you will be using individual permission grants, you must create a
  `Redirect URI` for the key. Any URL can be used. By default, this
  example uses `https://www.docusign.com`

#### The impersonated user's guid
The JWT will impersonate a user within your account. The user can be
an individual or a user representing a group such as "HR".

The example needs the guid assigned to the user.
The guid value for each user in your account is available from
the Administration tool in the **Users** section.

To see a user's guid, **Edit** the user's information.
On the **Edit User** screen, the guid for the user is shown as
the `API Username`.

## Run the examples

````
php main.php
````

## Support, Contributions, License

Submit support questions to [StackOverflow](https://stackoverflow.com). Use tag `docusignapi`.

Contributions via Pull Requests are appreciated.
All contributions must use the MIT License.

This repository uses the MIT license, see the
[LICENSE](https://github.com/docusign/eg-01-php-jwt/blob/master/LICENSE) file.
