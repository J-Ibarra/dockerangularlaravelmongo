<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Moloquent\Passport\Client;

class NewClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jcs:client
                            {--list : Show list of clients}
                            {--id= : The id of the client}
                            {--name= : The name of the client}
                            {--secret= : The secret of the client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a client for issuing access tokens';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if ($this->option('list')) {
            $clients = Client::all();

            foreach ($clients as $client) {
                $this->line('');
                $this->info('Client');
                $this->line('<comment>Client Name:</comment> ' . $client->name);
                $this->line('<comment>Client ID:</comment> ' . $client->_id);
                $this->line('<comment>Client Secret:</comment> ' . $client->secret);
            }
            $this->line('');
        } else {

            $name = $this->option('name') ?: $this->ask(
                'What should we name the client?'
            );

            $client = $this->create($name);

            $this->info('Client created successfully.');
            $this->line('<comment>Client Name:</comment> ' . $client->name);
            $this->line('<comment>Client ID:</comment> ' . $client->_id);
            $this->line('<comment>Client Secret:</comment> ' . $client->secret);
        }
    }

    /**
     * Store a new client.
     *
     * @param  string $name
     * @return Client
     */
    protected function create($name)
    {
        if ($this->option('id')) {
            $client = (new Client)->forceFill([
                '_id' => $this->option('id'),
                'user_id' => '',
                'name' => $name,
                'secret' => $this->option('secret') ?: str_random(40),
                'redirect' => '',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
            ]);

        } else {
            $client = (new Client)->forceFill([
                'user_id' => '',
                'name' => $name,
                'secret' => $this->option('secret') ?: str_random(40),
                'redirect' => '',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
            ]);
        }

        $client->save();

        return $client;
    }
}
