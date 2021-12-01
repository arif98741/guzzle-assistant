<?php
/*
 *  Last Modified: 6/28/21, 11:18 PM
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

class BDBulkSms extends AbstractProvider
{
    /**
     * BDBulkSms constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request TO Server
     */
    public function sendRequest()
    {
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();

        $query = [
            'token' => $config['token'],
            'to' => $number,
            'message' => $text,
        ];
        $response = Request::get('http://api.greenweb.com.bd/api2.php', $query);

        $body = $response->getBody();
        $smsResult = $body->getContents();

        $data['number'] = $number;
        $data['message'] = $text;
        return $this->generateReport($smsResult, $data);


    }

    /**
     * For mobile number
     * @param $mobile
     * @return string
     */
    private function formatNumber($mobile): string
    {
        if (is_array($mobile)) {
            return implode(',', $mobile);
        } else {
            return $mobile;
        }
    }

    /**
     * @return void
     * @throws ParameterException
     */
    public function errorException()
    {
        if (!array_key_exists('token', $this->senderObject->getConfig()))
            throw new ParameterException('token key is absent in configuration');
    }
}
