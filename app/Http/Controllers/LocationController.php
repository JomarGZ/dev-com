<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Nnjeim\World\Models\Country;
use Nnjeim\World\World;
use Nnjeim\World\WorldHelper;

class LocationController extends Controller
{
    protected $world;
    public function __construct(WorldHelper $world)
    {
        $this->world = $world;
    }
    public function getCountries()
    {
        return response()->json(World::getCountries());
    }
   
    public function getCities()
    {
        $countryId = request('country_id');

        $action = $this->world->cities([
            'filters' => [
                'country_id' => $countryId,
            ],
        ]);
        if ($action->success) {
            $cities = $action->data;
        }
        return response()->json($cities);
    }
}
