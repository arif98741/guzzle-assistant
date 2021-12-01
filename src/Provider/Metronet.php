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

use Xenon\GuzzleAssistant\Facades\Request;
use Xenon\GuzzleAssistant\Handler\ParameterException;
use Xenon\GuzzleAssistant\Sender;

class Metronet extends AbstractProvider
{
    /**
     * MentroNet constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Api and Send Message
     */
    public function sendRequest()
    {
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();

        $query = [
            'api_key' => $config['api_key'],
            'mask' => $config['mask'],
            'recipient' => $number,
            'message' => $text,
        ];

        $response = Request::get('202.164.208.212/smsnet/bulk/api', $query, false);

        $body = $response->getBody();
        $smsResult = $body->getContents();

        $data['number'] = $number;
        $data['message'] = $text;
        $report = $this->generateReport($smsResult, $data);
        return $report->getContent();
    }

    /**
     * @throws ParameterException
     */
    public function errorException()
    {
        if (!array_key_exists('api_key', $this->senderObject->getConfig())) {
            throw new ParameterException('api_key is absent in configuration');
        }
        if (!array_key_exists('mask', $this->senderObject->getConfig())) {
            throw new ParameterException('mask key is absent in configuration');
        }
    }
}
