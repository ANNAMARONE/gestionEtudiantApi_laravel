<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    public function etudiants(){
        return $this->hasMany(Evaluation::class);
    }
    public function matieres(){
        return $this->hasMany(Matiere::class);
    }
}
