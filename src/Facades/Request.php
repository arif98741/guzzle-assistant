<?php namespace Xenon\GuzzleAssistant\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static Xenon\GuzzleAssistant\Request get($requestUrl, array $query, bool $verify = false, $timeout = 10.0)
 * @see \Xenon\GuzzleAssistant\Request
 */
class Request extends Facade
{
    /**
     * @return string
     * @version v1.0.36
     * @since v1.0.36
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LaravelBDSmsRequest';
    }
}
