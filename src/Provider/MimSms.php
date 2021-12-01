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

/**
 * Class MimSms
 * @package Xenon\GuzzleAssistantLog\Provider
 * @version v1.0.20
 * @since v1.0.20
 */
class MimSms extends AbstractProvider
{
    /**
     * Mimsms constructor.
     * @param Sender $sender
     * @version v1.0.20
     * @since v1.0.20
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Api and Send Message
     * @version v1.0.20
     * @since v1.0.20
     */
    public function sendRequest()
    {
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();

        $query = [
            'api_key' => $config['api_key'],
            'type' => $config['type'],
            'senderid' => $config['senderid'],
            'contacts' => $number,
            'msg' => $text,
        ];

        $response = Request::get('https://esms.mimsms.com/smsapi', $query, false);

        $body = $response->getBody();
        $smsResult = $body->getContents();

        $data['number'] = $number;
        $data['message'] = $text;
        $report = $this->generateReport($smsResult, $data);
        return $report->getContent();
    }

    /**
     * @throws ParameterException
     * @version v1.0.20
     * @since v1.0.20
     */
    public function errorException()
    {
        if (!array_key_exists('api_key', $this->senderObject->getConfig())) {
            throw new ParameterException('api_key is absent in configuration');
        }
        if (!array_key_exists('type', $this->senderObject->getConfig())) {
            throw new ParameterException('type key is absent in configuration');
        }
        if (!array_key_exists('senderid', $this->senderObject->getConfig())) {
            throw new ParameterException('senderid key is absent in configuration');
        }
    }

}
