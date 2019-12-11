<?php
namespace KnotModule\Stk2kEventStream\Demo;

use Calgamo\Kernel\Kernel\ApplicationInterface;
use Calgamo\Kernel\Kernel\ApplicationType;
use Calgamo\Module\Application\SimpleApplication;
use Calgamo\Module\Stk2kEventStream\Stk2kEventStreamModule;

class Stk2kEventStreamApp extends SimpleApplication implements ApplicationInterface
{
    public static function type(): ApplicationType
    {
        return ApplicationType::of(ApplicationType::CLI);
    }

    /**
     * Configure application
     *
     * @throws
     */
    public function configure() : ApplicationInterface
    {
        $this->requireModule(Stk2kEventStreamModule::class);

        return $this;
    }
}