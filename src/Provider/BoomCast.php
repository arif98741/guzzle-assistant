<?php

namespace Xenon\GuzzleAssistant\Provider;

use GuzzleHttp\Client;
use Xenon\GuzzleAssistant\Handler\RenderException;
use Xenon\GuzzleAssistant\Sender;

class BoomCast extends AbstractProvider
{
    /**
     * BoomCast Constructor
     * @param Sender $sender
     * @version v1.0.32
     * @since v1.0.31
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @version v1.0.32
     * @since v1.0.31
     */
    public function sendRequest()
    {
        $mobile = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();


        $client = new Client();
        $response = $client->get($config['url'], [
            'query' => [
                "masking" => $config['masking'],
                "userName" => $config['username'],
                "password" => $config['password'],
                "MsgType" => "TEXT",
                "receiver" => $mobile,
                "message" => urlencode($text),
            ],
            'timeout' => 60,
            'read_timeout' => 60,
            'connect_timeout' => 60
        ]);


        $response = $response->getBody()->getContents();

        $data['number'] = $mobile;
        $data['message'] = $text;
        return $this->generateReport($response, $data);
    }

    /**
     * @throws RenderException
     * @version v1.0.32
     * @since v1.0.31
     */
    public function errorException()
    {
        $config = $this->senderObject->getConfig();

        if (!array_key_exists('url', $config))
            throw new RenderException('url key is absent in configuration');

        if (!array_key_exists('masking', $config))
            throw new RenderException('masking key is absent in configuration');

        if (!array_key_exists('username', $config))
            throw new RenderException('username key is absent in configuration');

        if (!array_key_exists('password', $config))
            throw new RenderException('password key is absent in configuration');
    }
}
