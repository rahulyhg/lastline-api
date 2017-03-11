<?php

namespace App\Providers;

use App\MatchMaking\Model\MatchMakingModel;
use App\MatchMaking\Repository\MatchMakingRepository;
use Illuminate\Support\ServiceProvider;

class MatchMakingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
	    $this->app->singleton(MatchMakingModel::class, function($app){
		    $matchMakingRepository = new MatchMakingRepository();

		    return new MatchMakingModel($matchMakingRepository);
	    });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
