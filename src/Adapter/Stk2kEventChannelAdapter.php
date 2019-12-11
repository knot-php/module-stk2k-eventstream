<?php
namespace KnotPhp\Module\Stk2kEventStream\Adapter;

use Stk2k\EventStream\Event;
use Stk2k\EventStream\EventChannel;
use Stk2k\EventStream\Exception\EventSourceIsNotPushableException;

use KnotLib\Kernel\EventStream\EventChannelInterface;
use KnotLib\Kernel\Exception\EventStreamException;


class Stk2kEventChannelAdapter implements EventChannelInterface
{
    /** @var EventChannel */
    private $channel;

    /**
     * Stk2kEventStreamAdapter constructor.
     *
     * @param EventChannel $channel
     */
    public function __construct(EventChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Subscribe to event channel
     *
     * @param string $event
     * @param callable $callback
     *
     * @return EventChannelInterface
     */
    public function listen(string $event, callable $callback) : EventChannelInterface
    {
        $this->channel->listen($event, $callback);
        return $this;
    }

    /**
     * Push an event to channel
     *
     * @param string $event
     * @param mixed $event_args
     *
     * @return EventChannelInterface
     *
     * @throws EventStreamException
     */
    public function push(string $event, $event_args = null) : EventChannelInterface
    {
        try{
            $this->channel->push(new Event($event, $event_args));
        }
        catch(EventSourceIsNotPushableException $e)
        {
            throw new EventStreamException('Event is not pushable.');
        }
        return $this;
    }

    /**
     * Update auto flush
     *
     * @param bool $auto_flush
     *
     * @return EventChannelInterface
     */
    public function setAutoFlush(bool $auto_flush) : EventChannelInterface
    {
        $this->channel->setAutoFlush($auto_flush);
        return $this;
    }

    /**
     * flush event
     *
     * @return EventChannelInterface
     */
    public function flush() : EventChannelInterface
    {
        $this->channel->flush();
        return $this;
    }
}