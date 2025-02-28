<?php

namespace Bangsystems\DotenvEditor\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Bangsystems\DotenvEditor\Console\Traits\CreateCommandInstanceTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DotenvDeleteKeyCommand extends Command
{
    use ConfirmableTrait;
    use CreateCommandInstanceTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'dotenv:delete-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete one setter in the .env file';

    /**
     * The .env file path.
     *
     * @var null|string
     */
    protected $filePath;

    /**
     * The key name use to add or update.
     *
     * @var string
     */
    protected $key;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->transferInputsToProperties();

        if (!$this->confirmToProceed()) {
            return false;
        }

    /**
     * Alias for the handle method for backwards compatibility.
     *
     * @return mixed
     */
    public function fire()
    {
        return $this->handle();
    }

        $this->line('Deleting key in your file...');
        $this->editor->load($this->filePath)->deleteKey($this->key)->save();
        $this->info("The key [{$this->key}] is deletted successfully.");
    }

    /**
     * Transfer inputs to properties of editing.
     *
     * @return void
     */
    protected function transferInputsToProperties()
    {
        $filePath = $this->stringToType($this->option('filepath'));

        $this->filePath = (is_string($filePath)) ? base_path($filePath) : null;
        $this->key      = $this->argument('key');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'Key name will be deleted.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['filepath', null, InputOption::VALUE_OPTIONAL, 'The file path should use to load for working. Do not use if you want to load file .env at root application folder.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
        ];
    }
}
