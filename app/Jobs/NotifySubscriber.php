<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifySubscriber implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The url instance.
     *
     */
    public $url;

    /**
     * The message instance.
     *
     */
    public $message;


    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $message)
    {
        $this->url = $url;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->api_post_request();
    }

    /**
     * Send api request to url
     */
    public function api_post_request()
    {
        $headers['content-type'] = 'application/json';
        $request_data = [
            'form_params' => $this->message
        ];
        $request_options['headers'] = $headers;

        try {
            $client = new Client();
            $response = $client->request('POST', $this->url, $request_data);
        } catch (\Exception $e) {
            \Log::debug($e);
            throw($e);
        }
    }
}
