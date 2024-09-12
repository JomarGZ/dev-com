<?php
namespace App\Services;

use Nnjeim\World\World;
use Nnjeim\World\WorldHelper;

class LocationService {
    private $worldHelper;
    public function __construct() {
        $this->worldHelper = new WorldHelper();
    }

    public function getCountryName($countryId)
    {
        if (!$countryId || !is_int($countryId)) {
            return null;
        }
        $country = World::countries([
            'filters' => [
                'id' => $countryId
            ]
        ]);
        if ($country->success 
            && !empty($country->data)
            && isset($country->data->first()['name'])) {
            return $country->data->first()['name'];
        }
        return null;
    }
    public function getCityName($cityId)
    {
        if (!$cityId || !is_int($cityId)) {
            return null;
        }
        $city = $this->worldHelper->cities([
            'filters' => [
                'id' => $cityId
            ]]);
        if ($city->success
            && !empty($city->data)
            && isset($city->data->first()['name'])) {
            return $city->data->first()['name'];
        }
        return null;
    }

    public function countries()
    {
        $action = World::Countries();
        if ($action->success
            && !empty($action->data)) {
            return $action->data;
        }
        return [];
    }

    public function citiesByCountryId($countryId)
    {
        
        if (!$countryId || !is_int($countryId)) {
            return [];
        }
        
        $action = $this->worldHelper->cities([
            'filters' => [
                'country_id' => $countryId
            ],
        ]);
        if ($action->success
            && !empty($action->data)) {
            return $action->data;
        }
        return [];
    }
}
