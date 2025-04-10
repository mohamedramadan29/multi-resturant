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
        'status',
        'banner'
    ];

    public function Owner()
    {
        return $this->belongsTo(Admin::class, 'owner_id');
    }

    public function getLogo()
    {
        return asset('assets/uploads/' . $this->id . '/' . 'logo/' . $this->logo);
    }
    public function getBanner()
    {
        return asset('assets/uploads/' . $this->id . '/' . 'banners/' . $this->banner);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function Setting(){
        return $this->hasOne(Setting::class,'resturant_id');
    }
}
