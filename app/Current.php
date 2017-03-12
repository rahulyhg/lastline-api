<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Current extends Model
{
	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
