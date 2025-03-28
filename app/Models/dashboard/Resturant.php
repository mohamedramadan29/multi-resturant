<?php

namespace App\Models\dashboard;

use Illuminate\Database\Eloquent\Model;

class Resturant extends Model
{
    protected $fillable = [
        "name",
        "description",
        "slug",
        "owner_id",
        "email",
        "phone",
        "address",
        "logo",
        'status'
    ];

    public function Owner()
    {
        return $this->belongsTo(Admin::class, 'owner_id');
    }
}
