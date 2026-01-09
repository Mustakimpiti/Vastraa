<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_type',
        'first_name',
        'last_name',
        'street_address',
        'apartment',
        'city',
        'state',
        'country',
        'zip',
        'phone',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get full address as string
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->street_address,
            $this->apartment,
            $this->city,
            $this->state . ' ' . $this->zip,
            $this->country
        ]);
        
        return implode(', ', $parts);
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Set this address as default and unset others
     */
    public function setAsDefault()
    {
        // Unset all other default addresses for this user
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);
        
        $this->update(['is_default' => true]);
    }

    /**
     * Boot method to handle default address logic
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($address) {
            // If this is the first address for the user, make it default
            $userAddressCount = static::where('user_id', $address->user_id)->count();
            if ($userAddressCount === 0) {
                $address->is_default = true;
            }
        });

        static::updating(function ($address) {
            // If setting as default, unset others
            if ($address->is_default && $address->isDirty('is_default')) {
                static::where('user_id', $address->user_id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    /**
     * Scope: Get default address for a user
     */
    public function scopeDefault($query, $userId)
    {
        return $query->where('user_id', $userId)
            ->where('is_default', true)
            ->first();
    }
}