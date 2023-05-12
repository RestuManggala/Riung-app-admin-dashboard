<?php

namespace App\Models;

use App\Models\Laporan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekeningKoran extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Mandiri()
    {
        return $this->hasMany(Laporan::class);
    }
}
