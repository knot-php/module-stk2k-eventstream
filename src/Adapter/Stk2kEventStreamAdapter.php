<?php
namespace KnotPhp\Module\Stk2kEventStream\Adapter;

use Stk2k\EventStream\Emitter\WildCardEventEmitter;
use Stk2k\EventStream\EventStream;
use Stk2k\EventStream\Source\SimpleEventSource;

use KnotLib\Kernel\EventStream\EventStreamInterface;
use KnotLib\Kernel\EventStream\EventChannelInterface;

class Stk2kEventStreamAdapter implements EventStreamInterface
{
    /** @var EventStream */
    private $eventstream;

    /** @var array */
    private $channel_adapters;

    /**
     * Stk2kEventStreamAdapter constructor.
     *
     * @param EventStream $eventstream
     */
    public function __construct(EventStream $eventstream)
    {
        $this->eventstream = $eventstream;
    }

    /**
     * Get channel object
     *
     * @param string $channel_id
     *
     * @return EventChannelInterface
     */
    public function channel(string $channel_id) : EventChannelInterface
    {
        if (isset($this->channel_adapters[$channel_id])){
            return $this->channel_adapters[$channel_id];
        }
        $adapter = new Stk2kEventChannelAdapter(
            $this->eventstream->channel(
                $channel_id,
                new SimpleEventSource(),
                new WildCardEventEmitter()
            )
        );
        $this->channel_adapters[$channel_id] = $adapter;
        return $adapter;
    }

    /**
     * Update auto flush flags in all channels
     *
     * @param bool $auto_flush
     *
     * @return EventStreamInterface
     */
    public function setAutoFlush(bool $auto_flush) : EventStreamInterface
    {
        $this->eventstream->setAutoFlush($auto_flush);
        return $this;
    }

    /**
     * flush event in all channels
     *
     * @return EventStreamInterface
     */
    public function flush() : EventStreamInterface
    {
        $this->eventstream->flush();
        return $this;
    }
}