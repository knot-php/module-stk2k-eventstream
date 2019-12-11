<?php
namespace KnotPhp\Module\Stk2kEventStream;

use Throwable;

use Stk2k\EventStream\EventStream;

use KnotLib\Kernel\EventStream\Channels;
use KnotLib\Kernel\EventStream\Events;
use KnotLib\Kernel\Exception\ModuleInstallationException;
use KnotLib\Kernel\Kernel\ApplicationInterface;
use KnotLib\Kernel\Module\AbstractModule;
use KnotLib\Kernel\Module\Components;

use KnotPhp\Module\Stk2kEventStream\Adapter\Stk2kEventStreamAdapter;

class Stk2kEventStreamModule extends AbstractModule
{
    /**
     * Declare dependent on another modules
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
    public static function requiredComponents() : array
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
        return Components::EVENTSTREAM;
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