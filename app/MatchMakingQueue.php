<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchMakingQueue extends Model
{

	/** @var string Name of the table */
    protected $table = 'matchmaking_queues';

	/**
	 * User one-to-one connection
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
