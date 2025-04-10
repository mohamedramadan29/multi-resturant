<?php

namespace App\Models\dashboard;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $guarded = [];

    public function restaurant()
    {
        return $this->belongsTo(Resturant::class, 'resturant_id');
    }

    public function getLogo()
    {
        return asset('assets/uploads/' . $this->resturant_id . '/' . 'logo/' . $this->logo);
    }
    public function getBanner()
    {
        return asset('assets/uploads/' . $this->resturant_id . '/' . 'banners/' . $this->banner);
    }
}
