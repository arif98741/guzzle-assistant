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

namespace Xenon\GuzzleAssistant;


use Exception;
use Illuminate\Support\Facades\Config;
use Xenon\GuzzleAssistant\Facades\Logger;
use Xenon\GuzzleAssistant\Handler\ParameterException;
use Xenon\GuzzleAssistant\Handler\RenderException;
use Xenon\GuzzleAssistant\Handler\ValidationException;
use Xenon\GuzzleAssistant\Helper\Helper;
use Xenon\GuzzleAssistant\Provider\AbstractProvider;

class Sender
{
    /**
     * @var AbstractProvider
     */
    private $provider;
    /**
     * @var
     */
    private $message;
    /**
     * @var
     */
    private $mobile;
    /**
     * @var
     */
    private $config;
    /**
     * @var
     */
    private $method;

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * @var null
     */
    private static $instance = null;


    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * This implementation lets you subclass the Singleton class while keeping
     * just one instance of each subclass around.
     */
    public static function getInstance(): Sender
    {
        if (!isset(self::$instance)) {
            self::$instance = new Sender();
        }

        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     * @return Sender
     * @throws Exception
     * @since v1.0.0
     */
    public function setConfig($config): Sender
    {
        $this->config = $config;
        return $this;
    }


    /**
     * Send Message Finally
     * @throws ParameterException
     * @throws ValidationException
     * @since v1.0.5
     */
    public function send()
    {

        if (!is_array($this->getConfig())) {
            throw  new ParameterException('config must be an array');
        }

        if (Helper::numberValidation($this->getMobile()) == false) {
            throw new ValidationException('Invalid Mobile Number');
        }
        if (strlen($this->getMobile()) > 11 || strlen($this->getMobile()) < 11) {
            throw new ParameterException('Invalid mobile number. It should be 11 digit');
        }
        if (empty($this->getMessage()))
            throw new ParameterException('Message should not be empty');

        $this->provider->errorException();

        $config = Config::get('sms');
        $response = $this->provider->sendRequest();
        $this->logGenerate($config, $response);

        return $response;
    }

    /**
     * @return mixed
     * @since v1.0.0
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     * @return Sender
     * @since v1.0.0
     */
    public function setMobile($mobile): Sender
    {
        $this->mobile = $mobile;
        return self::getInstance();
    }

    /**
     * @return mixed
     * @since v1.0.0
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return Sender
     * @since v1.0.0
     */
    public function setMessage($message = ''): Sender
    {

        $this->message = $message;
        return self::getInstance();
    }

    /**
     * @return mixed
     * @since v1.0.0
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Return this class object
     * @param $ProviderClass
     * @return Sender
     * @throws RenderException
     * @since v1.0.0
     */
    public function setProvider($ProviderClass): Sender
    {
        try {
            if (!class_exists($ProviderClass)) {
                throw new RenderException("Provider '$ProviderClass' not found");
            }

            if (!is_subclass_of($ProviderClass, AbstractProvider::class)) {
                throw new RenderException("Provider '$ProviderClass' is not a " . AbstractProvider::class);
            }
        } catch (XenonException $exception) {

            $exception->showException($ProviderClass);
        }

        $this->provider = new $ProviderClass($this);
        return $this;
    }

    /**
     * @param $config
     * @param $response
     */
    private function logGenerate($config, $response): void
    {
        if ($config['sms_log']) {


            if (is_object($response)) {
                $object = json_decode($response->getContent());
            } else {
                $object = json_decode($response);
            }

            $providerResponse = $object->response;

            Logger::createLog([
                'provider' => get_class($this->provider),
                'request_json' => json_encode([
                    'config' => $config['providers'][get_class($this->provider)],
                    'mobile' => $this->getMobile(),
                    'message' => $this->getMessage()
                ])
                ,
                'response_json' => json_encode($providerResponse)
            ]);
        }
    }

}
