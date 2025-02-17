<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue\Exceptions;

use LaravelHyperf\Queue\Contracts\Job;

use function Hyperf\Tappable\tap;

class TimeoutExceededException extends MaxAttemptsExceededException
{
    /**
     * Create a new instance for the job.
     */
    public static function forJob(Job $job): static
    {
        return tap(new static($job->resolveName() . ' has timed out.'), function ($e) use ($job) {
            $e->job = $job;
        });
    }
}
