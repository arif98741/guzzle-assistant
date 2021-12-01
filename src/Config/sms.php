<?php
/*
|--------------------------------------------------------------------------
| Configuration For Multiple Gateways
|--------------------------------------------------------------------------
|
| This file is key value a pair of providers. Individual provider has different types of
| params and api request params. This file is generated after running command below from your terminal.
| php artisan vendor:publish --provider="Xenon\\LaravelBDSmsLog\\LaravelBDSmsServiceProvider"
| .Here All data ar dynamically coming from .env file.
| Be sure to confirm to select default provider during use SMS facade, otherwise you can manually send sms
| by selecting provider.
| Happy coding !!!!!!!!!!!!
|
*/

use Xenon\GuzzleAssistant\Provider\Adn;
use Xenon\GuzzleAssistant\Provider\AjuraTech;
use Xenon\GuzzleAssistant\Provider\Alpha;
use Xenon\GuzzleAssistant\Provider\BDBulkSms;
use Xenon\GuzzleAssistant\Provider\BoomCast;
use Xenon\GuzzleAssistant\Provider\BulkSmsBD;
use Xenon\GuzzleAssistant\Provider\DianaHost;
use Xenon\GuzzleAssistant\Provider\DnsBd;
use Xenon\GuzzleAssistant\Provider\ElitBuzz;
use Xenon\GuzzleAssistant\Provider\GreenWeb;
use Xenon\GuzzleAssistant\Provider\Infobip;
use Xenon\GuzzleAssistant\Provider\MDL;
use Xenon\GuzzleAssistant\Provider\Metronet;
use Xenon\GuzzleAssistant\Provider\MimSms;
use Xenon\GuzzleAssistant\Provider\Mobireach;
use Xenon\GuzzleAssistant\Provider\Onnorokom;
use Xenon\GuzzleAssistant\Provider\Sms4BD;
use Xenon\GuzzleAssistant\Provider\Ssl;
use Xenon\GuzzleAssistant\Provider\Tense;

return [
    /*
     *-----------------------------------------------------------------------------------------------
     | Sms Log will mainly save sms request, provider name, response in database table called lbs_log
     | You Can change sms log to true or false according to your need. Default is true
     |---------------------------------------------------------------------------------------------
     */
    'sms_log' => true,

    /*
     *-----------------------------------------------------------------------------------------------
     | Default provider will be used during usage of facade ; SMS
     |---------------------------------------------------------------------------------------------
     */
    'default_provider' => env('SMS_DEFAULT_PROVIDER', Ssl::class),
    'providers' => [
        Adn::class => [
            'senderid' => env('SMS_ADN_SENDER_ID', ''),
            'api_key' => env('SMS_ADN_API_KEY', ''),
            'api_secret' => env('SMS_ADN_API_SECRET', ''),
            'request_type' => env('SMS_ADN_API_REQUEST_TYPE', ''),
            'message_type' => env('SMS_ADN_API_MESSAGE_TYPE', ''),
        ],
        AjuraTech::class => [
            'apikey' => env('SMS_AjuraTechReveSms_API_KEY', ''),
            'secretkey' => env('SMS_AjuraTechReveSms_API_SECRET_KEY', ''),
            'callerID' => env('SMS_AjuraTechReveSms_CALLER_ID', ''),
        ],
        Alpha::class => [],
        BDBulkSms::class => [
            'token' => env('SMS_BD_BULK_SMS_TOKEN', ''),
        ],
        BoomCast::class => [
            'url' => env('SMS_BOOM_CAST_URL', ''),
            'username' => env('SMS_BOOM_CAST_USERNAME', ''),
            'password' => env('SMS_BOOM_CAST_PASSWORD', ''),
            'masking' => env('SMS_BOOM_CAST_MASKING', ''),
        ],
        BulkSmsBD::class => [
            'username' => env('SMS_BULK_SMS_BD_USERNAME', ''),
            'password' => env('SMS_BULK_SMS_BD_PASSWORD', ''),
        ],
        DianaHost::class => [
            'senderid' => env('SMS_DIANA_HOST_SENDER_ID', ''),
            'api_key' => env('SMS_DIANA_HOST_API_KEY', ''),
            'type' => env('SMS_DIANA_HOST_TYPE', ''),
        ],
        DnsBd::class => [],
        ElitBuzz::class => [
            'url' => env('SMS_ELITBUZZ_URL', ''),
            'senderid' => env('SMS_ELITBUZZ_SENDER_ID', ''),
            'api_key' => env('SMS_ELITBUZZ_API_KEY', ''),
        ],
        GreenWeb::class => [
            'token' => env('SMS_GREEN_WEB_TOKEN', ''),
        ],
        Infobip::class => [
            'base_url' => env('SMS_INFOBIP_BASE_URL', ''),
            'user' => env('SMS_INFOBIP_USER', ''),
            'password' => env('SMS_INFOBIP_PASSWORD', ''),
            'from' => env('SMS_INFOBIP_FROM', ''),
        ],
        MDL::class => [
            'senderid' => env('SMS_MDL_SENDER_ID', ''),
            'api_key' => env('SMS_MDL_API_KEY', ''),
            'type' => env('SMS_MDL_TYPE', ''),
        ],
        Metronet::class => [
            'api_key' => env('SMS_METRONET_API_KEY', ''),
            'mask' => env('SMS_METRONET_MASK', ''),
        ],
        MimSms::class => [
            'senderid' => env('SMS_MIM_SMS_SENDER_ID', ''),
            'api_key' => env('SMS_MIM_SMS_API_KEY', ''),
            'type' => env('SMS_MIM_SMS_TYPE', ''),
        ],
        Mobireach::class => [
            'Username' => env('SMS_MOBIREACH_USERNAME', ''),
            'Password' => env('SMS_MOBIREACH_PASSWORD', ''),
            'From' => env('SMS_MOBIREACH_FROM', ''),
        ],
        Onnorokom::class => [
            'userName' => env('SMS_ONNOROKOM_USERNAME', ''),
            'userPassword' => env('SMS_ONNOROKOM_PASSWORD', ''),
            'type' => env('SMS_ONNOROKOM_TYPE', ''),
            'maskName' => env('SMS_ONNOROKOM_MASK', ''),
            'campaignName' => env('SMS_ONNOROKOM_CAMPAIGN_NAME', ''),
        ],
        Sms4BD::class => [
            'publickey' => env('SMS_SMS4BD_PUBLIC_KEY', ''),
            'privatekey' => env('SMS_SMS4BD_PRIVATE_KEY', ''),
            'type' => env('SMS_SMS4BD_TYPE', ''),
            'sender' => env('SMS_SMS4BD_SENDER', ''),
            'delay' => env('SMS_SMS4BD_DELAY', ''),
        ],
        Ssl::class => [
            'api_token' => env('SMS_SSL_API_TOKEN', ''),
            'sid' => env('SMS_SSL_SID', ''),
            'csms_id' => env('SMS_SSL_CSMS_ID', ''),
        ],
        Tense::class => [
            'user' => env('SMS_TENSE_USER', ''),
            'password' => env('SMS_TENSE_PASSWORD', ''),
            'campaign' => env('SMS_TENSE_CAMPAIGN', ''),
            'masking' => env('SMS_TENSE_MASKING', ''),
        ],
    ]
];

