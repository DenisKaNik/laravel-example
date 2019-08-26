<?php

namespace App\Jobs;

use Exception;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $queue = 'default';

    public $params = [];

    /**
     * Create a new job instance.
     *
     * @param array $params
     * @throws Exception
     */
    public function __construct($params = [])
    {
        if (!isset($params['subject']) || !isset($params['to']) || !isset($params['view'])) {
            throw new Exception('Not enough options to form a letter.');
        }

        $this->params = $params;
    }

    /**
     * @param Mailer $mailer
     * @throws Exception
     */
    public function handle(Mailer $mailer)
    {
        $toFields = ['to', 'cc', 'bcc'];
        foreach ($toFields as $field) {
            ${$field} = collect(
                !empty($this->params[$field]) ? $this->params[$field] : [])->filter(
                function ($value) {
                    return \Validator::make(['email' => trim($value)], ['email' => 'email'])->passes();
                }
            );
        }

        if ($to->isEmpty()) {
            return;
        }

        try {
            $mailer->send(
                'emails.' . $this->params['view'],
                $this->params,
                function (Message $message) use ($toFields, $to, $cc, $bcc) {
                    //
                    $message->subject($this->params['subject']);

                    foreach ($toFields as $field) {
                        foreach ($$field as $addr) {
                            $message->$field(trim($addr));
                        }
                    }
                }
            );
        } catch (\Exception $exception) {

            if ($this->connection === "sync") {
                // Running synchronously - there's only one attempt,
                // so don't try again
                throw $exception;
            }

            $attempts = $this->attempts();
            if ($attempts == 1) {
                $delay = 30;
            } elseif ($attempts <= 4) {
                $delay = 60;
            } elseif ($attempts <= 14) {
                $delay = 5 * 60;
            } elseif ($attempts > 60) {
                $this->failed();
                return;
            } else {
                $delay = 10 * 60;
            }

            $this->release($delay);
        }
    }
}
