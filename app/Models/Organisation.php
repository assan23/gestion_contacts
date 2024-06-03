<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'entreprise',
        'adresse',
        'code_postal',
        'ville',
        'statut'
    ];

    public function contacts()
    {
        return $this->belongsTo(Contact::class);
    }

    protected static function booted()
    {
        static::creating(function ($contact) {
            $contact->entreprise = ucwords(strtolower($contact->entreprise));
            $contact->ville = ucwords(strtolower($contact->ville));
        });

        static::updating(function ($contact) {
            $contact->entreprise = ucwords(strtolower($contact->entreprise));
            $contact->ville = ucwords(strtolower($contact->ville));
        });
    }
}
