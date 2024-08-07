<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Evaluation extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_evaluation',
        'note',
        'etudiant_id',
        'matiere_id',
    ];
    public function etudiants(){
        return $this->hasMany(Evaluation::class);
    }
    public function matieres(){
        return $this->hasMany(Matiere::class);
    }
}
