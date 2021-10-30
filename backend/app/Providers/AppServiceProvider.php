<?php

namespace App\Providers;

use App\Interfaces\FixtureInterface;
use App\Interfaces\GameSimulationInterface;
use App\Interfaces\PredictionInterface;
use App\Services\Fixture\RoundRobinFixtureService;
use App\Services\GameSimulation\SimpleGameSimulationService;
use App\Services\Prediction\PredictionBySimulationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FixtureInterface::class, RoundRobinFixtureService::class);
        $this->app->bind(GameSimulationInterface::class, SimpleGameSimulationService::class);
        $this->app->bind(PredictionInterface::class, PredictionBySimulationService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(! app()->isProduction());
        JsonResource::withoutWrapping();
    }
}
