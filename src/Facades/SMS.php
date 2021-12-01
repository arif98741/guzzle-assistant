<?php namespace Xenon\GuzzleAssistant\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Xenon\GuzzleAssistant\SMS via(string $provider)
 * @method static mixed shoot(string $mobile, string $text)
 *
 * @see \Xenon\GuzzleAssistant\SMS
 */
class SMS extends Facade
{
    /**
     * @return string
     * @version v1.0.32
     * @since v1.0.31
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LaravelBDSms';
    }
}
