<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_line1', 'address_line2', 'address_line3',
        'city', 'state', 'zip', 'country',
        'phone1', 'phone2', 'email',
        'facebook_url', 'instagram_url', 'twitter_url', 'pinterest_url',
        'map_embed_url', 'latitude', 'longitude'
    ];

    public static function getSettings()
    {
        return static::first() ?? static::create([
            'address_line1' => 'F 316, Ananta Swagatam',
            'address_line2' => 'Bill Kalali Road',
            'city' => 'Vadodara',
            'state' => 'Gujarat',
            'zip' => '391410',
            'country' => 'India',
            'phone1' => '+91 94267 24282',
            'phone2' => '+91 94294 08688',
        ]);
    }

    public function getFullAddress()
    {
        $parts = array_filter([
            $this->address_line1,
            $this->address_line2,
            $this->address_line3,
            $this->city . ' - ' . $this->zip,
            $this->state,
            $this->country
        ]);
        
        return implode(', ', $parts);
    }
}