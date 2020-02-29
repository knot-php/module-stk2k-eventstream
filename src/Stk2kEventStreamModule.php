<?php
namespace KnotPhp\Module\Stk2kEventStream;

use Throwable;

use Stk2k\EventStream\EventStream;

use KnotLib\Kernel\EventStream\Channels;
use KnotLib\Kernel\EventStream\Events;
use KnotLib\Kernel\Exception\ModuleInstallationException;
use KnotLib\Kernel\Kernel\ApplicationInterface;
use KnotLib\Kernel\Module\ModuleInterface;
use KnotLib\Kernel\Module\ComponentTypes;

use KnotPhp\Module\Stk2kEventStream\Adapter\Stk2kEventStreamAdapter;

class Stk2kEventStreamModule implements ModuleInterface
{
    /**
     * Declare dependency on another modules
     *
     * @return array
     */
    public static function requiredModules() : array
    {
        return [];
    }
    
    /**
     * Declare dependent on components
     *
     * @return array
     */
    public static function requiredComponentTypes() : array
    {
        return [];
    }

    /**
     * Declare component type of this module
     *
     * @return string
     */
    public static function declareComponentType() : string
    {
        return ComponentTypes::EVENTSTREAM;
    }

    /**
     * Install module
     *
     * @param ApplicationInterface $app
     *
     * @throws ModuleInstallationException
     */
    public function install(ApplicationInterface $app)
    {
        try{
            $eventstream = new Stk2kEventStreamAdapter(new EventStream());
            $app->eventstream($eventstream);

            // fire event
            $eventstream->channel(Channels::SYSTEM)->push(Events::EVENTSTREAM_ATTACHED, $eventstream);
        }
        catch(Throwable $e)
        {
            throw new ModuleInstallationException(self::class, $e->getMessage(), 0, $e);
        }
    }
}