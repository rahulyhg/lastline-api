<?php

namespace App\Console\Commands;

use App\MatchMaking\Model\MatchMakingModel;
use Illuminate\Console\Command;

class MatchMakingFindJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matchmaking:find';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create match.';

    /** @var MatchMakingModel  */
    private $matchMakingModel;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->matchMakingModel = app(MatchMakingModel::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$this->matchMakingModel->findMatch();
    }
}
