<?php namespace Xenon\GuzzleAssistant\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @method static Xenon\GuzzleAssistant\Log\Log createLog(array $data)
 * @method static Xenon\GuzzleAssistant\Log\Log viewLastLog()
 * @method static Xenon\GuzzleAssistant\Log\Log viewAllLog()
 * @method static Xenon\GuzzleAssistant\Log\Log logByProvider()
 * @method static Xenon\GuzzleAssistant\Log\Log logByDefaultProvider()
 * @method static Xenon\GuzzleAssistant\Log\Log total()
 * @method static Xenon\GuzzleAssistant\Log\Log toArray()
 * @method static Xenon\GuzzleAssistant\Log\Log toJson()
 *
 * @see \Xenon\GuzzleAssistant\Log\Log
 */
class Logger extends Facade
{
    /**
     * @return string
     * @version v1.0.35
     * @since v1.0.35
     */
    protected static function getFacadeAccessor(): string
    {
        return 'LaravelBDSmsLogger';
    }
}
