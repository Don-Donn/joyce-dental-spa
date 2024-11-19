<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class DentalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gingivitis',
        'early',
        'moderate',
        'advance',
        'class',
        'overjet',
        'overbite',
        'midline',
        'crossbite',
        'ortho',
        'stay',
        'others',
        'clenching',
        'clicking',
        'tris',
        'muscle',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statuses()
    {
        return $this->hasMany(DentitionStatus::class, 'record_id');
    }

    // Mutators for Encryption
    public function setGingivitisAttribute($value)
    {
        $this->attributes['gingivitis'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setEarlyAttribute($value)
    {
        $this->attributes['early'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setModerateAttribute($value)
    {
        $this->attributes['moderate'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setAdvanceAttribute($value)
    {
        $this->attributes['advance'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setClassAttribute($value)
    {
        $this->attributes['class'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setOverjetAttribute($value)
    {
        $this->attributes['overjet'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setOverbiteAttribute($value)
    {
        $this->attributes['overbite'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setMidlineAttribute($value)
    {
        $this->attributes['midline'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setCrossbiteAttribute($value)
    {
        $this->attributes['crossbite'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setOrthoAttribute($value)
    {
        $this->attributes['ortho'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setStayAttribute($value)
    {
        $this->attributes['stay'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setOthersAttribute($value)
    {
        $this->attributes['others'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setClenchingAttribute($value)
    {
        $this->attributes['clenching'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setClickingAttribute($value)
    {
        $this->attributes['clicking'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setTrisAttribute($value)
    {
        $this->attributes['tris'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function setMuscleAttribute($value)
    {
        $this->attributes['muscle'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    // Accessors for Decryption
    public function getGingivitisAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for gingivitis: ' . $e->getMessage());
            return null;
        }
    }

    public function getEarlyAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for early: ' . $e->getMessage());
            return null;
        }
    }

    public function getModerateAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for moderate: ' . $e->getMessage());
            return null;
        }
    }

    public function getAdvanceAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for advance: ' . $e->getMessage());
            return null;
        }
    }

    public function getClassAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for class: ' . $e->getMessage());
            return null;
        }
    }

    public function getOverjetAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for overjet: ' . $e->getMessage());
            return null;
        }
    }

    public function getOverbiteAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for overbite: ' . $e->getMessage());
            return null;
        }
    }

    public function getMidlineAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for midline: ' . $e->getMessage());
            return null;
        }
    }

    public function getCrossbiteAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for crossbite: ' . $e->getMessage());
            return null;
        }
    }

    public function getOrthoAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for ortho: ' . $e->getMessage());
            return null;
        }
    }

    public function getStayAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for stay: ' . $e->getMessage());
            return null;
        }
    }

    public function getOthersAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for others: ' . $e->getMessage());
            return null;
        }
    }

    public function getClenchingAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for clenching: ' . $e->getMessage());
            return null;
        }
    }

    public function getClickingAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for clicking: ' . $e->getMessage());
            return null;
        }
    }

    public function getTrisAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for tris: ' . $e->getMessage());
            return null;
        }
    }

    public function getMuscleAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Decryption error for muscle: ' . $e->getMessage());
            return null;
        }
    }
}
