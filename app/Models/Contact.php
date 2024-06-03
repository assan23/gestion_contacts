<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'organisation_id'
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }


    protected static function booted()
    {
        static::creating(function ($contact) {
            $contact->nom = ucwords(strtolower($contact->nom));
            $contact->prenom = ucwords(strtolower($contact->prenom));
            $contact->email = strtolower($contact->email);
        });

        static::updating(function ($contact) {
            $contact->nom = ucwords(strtolower($contact->nom));
            $contact->prenom = ucwords(strtolower($contact->prenom));
            $contact->email = strtolower($contact->email);
        });
    }

}
