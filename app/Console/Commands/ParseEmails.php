<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Email;
use PhpMimeMailParser\Parser;

class ParseEmails extends Command
{
    protected $signature = 'emails:parse';
    protected $description = 'Parse unprocessed emails';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $emails = Email::where('processed', false)->where('deleted', false)->get();

        foreach ($emails as $email) {
            $parser = new Parser();
            $parser->setText($email->email);
            $plainText = $parser->getMessageBody('text');
            $plainText = preg_replace('/[^\P{C}\n]+/u', '', $plainText);

            $email->raw_text = $plainText;
            $email->processed = true;
            $email->save();
        }

        $this->info('Unprocessed emails have been parsed.');
    }
}