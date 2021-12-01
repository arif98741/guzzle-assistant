<?php
/*
 *  Last Modified: 6/29/21, 12:06 AM
 *  Copyright (c) 2021
 *  -created by Ariful Islam
 *  -All Rights Preserved By
 *  -If you have any query then knock me at
 *  arif98741@gmail.com
 *  See my profile @ https://github.com/arif98741
 */

namespace Xenon\GuzzleAssistant\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Xenon\GuzzleAssistant\Handler\ParameterException;
use Xenon\GuzzleAssistant\Sender;

class AjuraTech extends AbstractProvider
{
    /**
     * Ajuratech constructor.
     * @param Sender $sender
     * @version v1.0.34
     * @since v1.0.34
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Api and Send Message
     * @return false|string
     * @throws GuzzleException
     * @since v1.0.34
     * @version v1.0.34
     */
    public function sendRequest()
    {
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();

        $client = new Client([
            'base_uri' => 'https://smpp.ajuratech.com:7790/sendtext?json',
            'timeout' => 10.0,
            'verify' => false
        ]);

        $response = $client->request('GET', '', [
            'query' => [

                'apikey' => $config['apikey'],
                'secretkey' => $config['secretkey'],
                'callerID' => $config['callerID'],
                'toUser' => $number,
                'messageContent' => $text,
            ]
        ]);
        $body = $response->getBody();
        $smsResult = $body->getContents();

        $data['number'] = $number;
        $data['message'] = $text;
        $report = $this->generateReport($smsResult, $data);
        return $report->getContent();
    }

    /**
     * @throws ParameterException
     * @version v1.0.34
     * @since v1.0.34
     */
    public function errorException()
    {
        if (!array_key_exists('apikey', $this->senderObject->getConfig())) {
            throw new ParameterException('apikey is absent in configuration');
        }
        if (!array_key_exists('secretkey', $this->senderObject->getConfig())) {
            throw new ParameterException('secretkey is absent in configuration');
        }
        if (!array_key_exists('callerID', $this->senderObject->getConfig())) {
            throw new ParameterException('callerID is absent in configuration');
        }
    }
}
