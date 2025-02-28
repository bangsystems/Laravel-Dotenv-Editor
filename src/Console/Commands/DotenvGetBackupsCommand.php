<?php

namespace Bangsystems\DotenvEditor\Console\Commands;

use Illuminate\Console\Command;
use Bangsystems\DotenvEditor\Console\Traits\CreateCommandInstanceTrait;
use Symfony\Component\Console\Input\InputOption;

class DotenvGetBackupsCommand extends Command
{
    use CreateCommandInstanceTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dotenv:get-backups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all the .env file backup versions';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = ['File name', 'File path', 'Created at'];
        $backups = ($this->option('latest')) ? [$this->editor->getLatestBackup()] : $this->editor->getBackups();

        if ($this->option('latest')) {
            $latest = $this->editor->getLatestBackup();

            if (!is_null($latest)) {
                $backups = [$latest];
                $total = 1;
            }

    /**
     * Alias for the handle method for backwards compatibility.
     *
     * @return mixed
     */
    public function fire()
    {
        return $this->handle();
    } else {
                $total = 0;
            }
        } else {
            $backups = $this->editor->getBackups();
            $total   = count($backups);
        }

        $this->line('Loading backup files...');
        $this->line('');

        if (0 == $total) {
            $this->info('You have not any backup file');
        } elseif (1 == $total) {
            $this->table($headers, $backups);
            $this->line('');
            $this->info('There is 1 backup file found from your request');
        } else {
            $this->table($headers, $backups);
            $this->line('');
            $this->info("There are {$total} backup files found from your request");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['latest', 'l', InputOption::VALUE_NONE, 'Only get latest version from backup files.'],
        ];
    }
}
