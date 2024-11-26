<?php

declare(strict_types=1);

namespace SwooleTW\Hyperf\Queue\Connectors;

use Pheanstalk\Contract\SocketFactoryInterface;
use Pheanstalk\Pheanstalk;
use Pheanstalk\Values\Timeout;
use SwooleTW\Hyperf\Queue\BeanstalkdQueue;
use SwooleTW\Hyperf\Queue\Contracts\Queue;

class BeanstalkdConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     */
    public function connect(array $config): Queue
    {
        return new BeanstalkdQueue(
            $this->pheanstalk($config),
            $config['queue'],
            $config['retry_after'] ?? Pheanstalk::DEFAULT_TTR,
            $config['block_for'] ?? 0,
            $config['after_commit'] ?? false
        );
    }

    /**
     * Create a Pheanstalk instance.
     */
    protected function pheanstalk(array $config): Pheanstalk
    {
        return Pheanstalk::create(
            $config['host'],
            $config['port'] ?? SocketFactoryInterface::DEFAULT_PORT,
            isset($config['timeout']) ? new Timeout($config['timeout']) : null,
        );
    }
}
