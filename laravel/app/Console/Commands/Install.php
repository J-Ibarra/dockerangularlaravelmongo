<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Passport\Passport;
use phpseclib\Crypt\RSA;
use Symfony\Component\Process\Process;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jcs:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $bar;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(RSA $rsa)
    {
        $this->bar = $this->output->createProgressBar(12);
        $composer = $this->findComposer();

        $this->info($this->bar->display() . '    ->    ' .
            '<comment> init install</comment>' . PHP_EOL);

        $commands = [
            $composer . ' run-script post-root-package-install',
            $composer . ' run-script post-install-cmd',
            $composer . ' run-script post-create-project-cmd',
            $composer . ' run-script post-update-cmd',
        ];

        $commands = array_map(function ($value) {
            return $value . ' --no-ansi';
        }, $commands);

        $process = new Process(implode(' && ', $commands));

        $process->run(function ($type, $line) {
            $this->info($this->bar->advance() . '    ->    ' .
                '<comment>' . $line . '</comment>');
        });

        $keys = $rsa->createKey(4096);

        file_put_contents(Passport::keyPath('oauth-private.key'), array_get($keys, 'privatekey'));
        file_put_contents(Passport::keyPath('oauth-public.key'), array_get($keys, 'publickey'));

        $this->info($this->bar->advance() . '    ->    ' .
            '<comment>Generate passport keys</comment>');
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        chdir('../config');
        if (file_exists(getcwd() . '/composer.phar')) {
            $r = getcwd() . '/composer.phar';
            chdir('../laravel');
            return $r;
        }
    }
}
