<?php

    namespace App\Jobs;

    use App\Models\Attachment;
    use App\Models\Email;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldBeUnique;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Mail;
    use App\Mail\SendEmail;

    class SendEmailJob implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        /**
         * Create a new job instance.
         *
         * @return void
         */
        protected $email;
        public function __construct($email)
        {
            //
            $this->email = $email;
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle()
        {
            //
            Mail::to($this->email['to'])->send(new SendEmail($this->email));

            $email = Email::create([
                'to' => $this->email['to'],
                'subject' => $this->email['subject'],
                'body' => $this->email['body'],
            ]);

            $attachments = array();

            foreach($this->email['attachments'] as $attachment) {
                $att = new Attachment();
                $att->name = $attachment['name'];
                $att->value = $attachment['value'];

                $attachments[]= $att;
            }

            $email->attachments()->saveMany($attachments);
        }
    }
