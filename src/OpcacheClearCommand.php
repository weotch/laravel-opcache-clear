<?php

namespace MicheleCurletta\LaravelOpcacheClear;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Crypt;

class OpcacheClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opcache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear OpCache';

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
        $client = new Client(['base_uri' => config('app.url', 'http://localhost')]);
        
        $originalToken = config('app.key');

        $encryptedToken = Crypt::encrypt($originalToken);

        $response = json_decode(
            $client->request('GET', '/opcache-clear', ['query' => ['token' => $encryptedToken]])->getBody(), true
        );

        if(($response['result']))
            $this->line('So far, so good.');
        else
            $this->line('Ooops!');

    }
}
