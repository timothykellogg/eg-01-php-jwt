<?php
    require_once('vendor/docusign/esign-client/autoload.php');
    include_once 'ds_config.php';

    $integrator_key="1528fef0-e71e-42d0-8378-d2531e4ef3df";
    $username="d3171686-3d9b-4da8-9f49-dda4868899a6";
    $password="
    -----BEGIN RSA PRIVATE KEY-----
    MIIEpQIBAAKCAQEAu7Cjm/u5BZraS5GvAV1OQRsX/Gi2DXc1eV5M23gQnfiAqH/7
    Z+DexUIjNwTRGk3BYDGPE/eLsN8NYq4KUdADfOdjI5tlILMq8+ab/dzk/tSC8giE
    2OVC0oCb3EDCVy8ePqWkV6/gUyboEL88Syi1KMXQYbmudzn+apSl3N1EnaA4oQFk
    tPWEi/sJu/ofl8kylRDIyRePugXjX3H752HQeQRtgb+9t5l6MC7T1b32ASS2WuwJ
    EZtQS0yW09LKA3evrBM78MxBEDTl6TJjtnPmfrAy59Td1TPFyBdL/T9sFIVqiKT4
    rVS/YcWc3qCRRVzpiyqfQCwmFfZzy/q2aCBfmwIDAQABAoIBAE3sWzDihIGQNftT
    462UWG3tWrr/mj3i9T+LaCtiILwFNR0/7VfGY5bQC6DHDi12hMd0K+vlRYjMQllq
    2nv2+cu8oUtiM80stbOHVdJDCIvIHQlxgf4uyNxuasc517WsqUjnKmEBcwfyyjxR
    uS2XHAdugUJhfc6gNEF5r5cQAnHSIfn9vk1h6Q8b8fhfP/SyAzz75s6C12cuIVwi
    KKo0aK6fPqepICl5KCWWrlwDOwpTtaIMiBUpP2+2yLLZINuXyUxYupDM72ws/TIb
    ujgvC0MrHyEdYnpdnZmAtOXCfO4HKD6pIT2NGPNoQFuBlZ6boiHCJKFhomWxURd7
    F3UREIkCgYEA6LP5JrRqDSt9wbsDNIne+MY51eeTkS8/7QzH6jFYYjlgH1GNaRnM
    wXEES4AFch0SwD7NEqpSuPO7zXmDNbTYQdgw332b+Ls0/rtFMpucrTw4V9sZXSXM
    s0ayuE/KoYwbfzgwTqZnLSx0lI9WOVTzs4vfUnQSJ1Sx+R8zWefIfscCgYEAznsC
    6gTyL5Hk6EvFSNJNUX+9Yy2/cGCNORMmq3uPtkWDdQwA6v+n9MuPF7woF4a14Rfb
    dq8T70tjghrBzZlZgUPDIngHg0RLntEJH34gs3d0P9U+qcGbhDU3sZ70L+zQCcMs
    AIiAM0LE3VVSZ9GweXjvnlF8ShZCL34Gg0XdFI0CgYEAtnmCc55f1wn2qDb80XMX
    nJ7cdWcNqXiSuVEfZv7g3s09GfH6YKMxk7MK+iVen9g6fvQAHZXgHlZKO1sAz9mL
    Bz7/PBGkgAxVBzdUkNXDq3igegw+PHPKq/5RYQR40esrGLy37MTB/YNxu5kWtQhv
    vah+K4sHPT5F/SNBQkvmRbsCgYEAjjCB2jwbt4yFkT6UlkhUfFo2RnU7jxy+Q96f
    U5ncZo3KMDFa9Hmn5NjFKnglN8ZJu7+dH0cDuFc3KGJascX3sB/E4hi8O7YtSSn0
    WV6XEF+ji03DQE2WVd38A3JOAC7ZOM/RnnBhsGs7fJwECoCJQa15fZHpwG9Blsj3
    nTDgRQUCgYEA3P0HwK/O1OgPjJnGJKOpXSTnmKg/xw/nF4OijOhabuJ8C7B4O1Vz
    hVbQeCSoQl7QPnyAtEccjyG8x6V+b58A3LNR6vri/FKimN3pgvJXgmcFjcyXH5FQ
    GDYuk83R5/RzEeLYa3kNgpZcTJ2eZQQFR2gcS8SPPcZN+g1ji36/jlQ=
    -----END RSA PRIVATE KEY-----";

    new DSConfig();
    print "client id: ".DSConfig::client_id()."\n";
    print "client id: ".DSConfig::private_key()."\n";
    // $host = "https://demo.docusign.net/restapi";
    // $config = new DocuSign\eSign\Configuration();
    // $config->setHost($host);
    // $config->addDefaultHeader("X-DocuSign-Authentication",
    // "{\"Username\":\"" . $username . "\",\"Password\":\"" . $password . "\",\"IntegratorKey\":\"" . $integrator_key . "\"}");

    // $apiClient = new DocuSign\eSign\ApiClient($config);

    // $authenticationApi = new DocuSign\eSign\Api\AuthenticationApi($apiClient);
    // $options = new \DocuSign\eSign\Api\AuthenticationApi\LoginOptions();
    // $loginInformation = $authenticationApi->login($options);
    // print "login successfuly"
    ?>