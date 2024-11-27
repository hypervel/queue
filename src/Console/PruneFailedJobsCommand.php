<?php

declare(strict_types=1);

namespace SwooleTW\Hyperf\Queue\Console;

use Hyperf\Command\Command;
use SwooleTW\Hyperf\Queue\Failed\FailedJobProviderInterface;
use SwooleTW\Hyperf\Queue\Failed\PrunableFailedJobProvider;
use SwooleTW\Hyperf\Support\Carbon;
use SwooleTW\Hyperf\Support\Traits\HasLaravelStyleCommand;

class PruneFailedJobsCommand extends Command
{
    use HasLaravelStyleCommand;

    /**
     * The console command signature.
     */
    protected ?string $signature = 'queue:prune-failed
                {--hours=24 : The number of hours to retain failed jobs data}';

    /**
     * The console command description.
     */
    protected string $description = 'Prune stale entries from the failed jobs table';

    /**
     * Execute the console command.
     */
    public function handle(): ?int
    {
        $failer = $this->app->get(FailedJobProviderInterface::class);

        if ($failer instanceof PrunableFailedJobProvider) {
            $count = $failer->prune(Carbon::now()->subHours($this->option('hours')));
        } else {
            $this->error('The [' . class_basename($failer) . '] failed job storage driver does not support pruning.');

            return 1;
        }

        $this->info("{$count} entries deleted.");

        return null;
    }
}
