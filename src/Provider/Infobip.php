<?php

namespace Xenon\GuzzleAssistant\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Xenon\GuzzleAssistant\Handler\RenderException;
use Xenon\GuzzleAssistant\Sender;

class Infobip extends AbstractProvider
{
    /**
     * Infobip Constructor
     * @param Sender $sender
     * @version v1.0.32
     * @since v1.0.31
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * @param $config
     * @return string[]
     * @version v1.0.32
     * @since v1.0.31
     */
    private function getHeaders($config): array
    {
        return [
            'accept' => "application/json",
            'authorization' => 'Basic ' . base64_encode($config['user'] . ':' . $config['password']),
            'content-type' => 'application/json'
        ];
    }

    /**
     * @return JsonResponse
     * @throws GuzzleException
     * @version v1.0.32
     * @since v1.0.31
     */
    public function sendRequest()
    {
        $mobile = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();

        $url = $config['base_url'] . "/sms/2/text/single";

        $client = new Client();
        $response = $client->request('POST', $url, [
            'headers' => $this->getHeaders($config),
            'json' => [
                'from' => $config['from'],
                'to' => "+88" . $mobile,
                'text' => $text
            ]
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

        if (!array_key_exists('base_url', $config))
            throw new RenderException('base_url key is absent in configuration');

        if (!array_key_exists('from', $config))
            throw new RenderException('from key is absent in configuration');

        if (!array_key_exists('user', $config))
            throw new RenderException('user key is absent in configuration');

        if (!array_key_exists('password', $config))
            throw new RenderException('password key is absent in configuration');
    }
}
