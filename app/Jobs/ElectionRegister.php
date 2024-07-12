<?php

namespace App\Jobs;

use App\Models\ElectionData;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ElectionRegister implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $election_id;
    /**
     * Create a new job instance.
     */
    public function __construct($data, $election_id)
    {
        $this->data = $data;
        $this->election_id = $election_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $d) {
            ElectionData::create(
                [
                    'voter_name' => $d->first_name . " " . $d->last_name,
                    'voter_id' => $d->id,
                    'election_id' => $this->election_id
                ]
            );
        }
    }
}
