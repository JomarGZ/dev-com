<?php

namespace App\Models;

use App\Services\LocationService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Nnjeim\World\World;
use Nnjeim\World\WorldHelper;

class Profile extends Model
{
    use HasFactory;
    protected $guarded = [];

   
    protected static function booted(): void
    {
        static::saving(function (Profile $profile) {
            $locationService = new LocationService();
            if ($profile->country_id) {
               $profile->country = $locationService->getCountryName($profile->country_id);
            }
            if ($profile->city_id) {
              $profile->city = $locationService->getCityName($profile->city_id);
            }
        });
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
