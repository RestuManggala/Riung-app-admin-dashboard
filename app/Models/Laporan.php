<?php

namespace App\Models;

use App\Models\User;
use App\Models\RekeningKoran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primarykey = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function rekeningKoran()
    {
        return $this->belongsTo(RekeningKoran::class, 'nama_bank', 'id');
    }
}
