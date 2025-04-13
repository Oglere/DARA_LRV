<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRepository extends Model
{
    use HasFactory;

    protected $table = 'document_repository';
    protected $primaryKey = 'document_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'student_id',
        'teacher_id',
        'authors',
        'citations',
        'metadata',
        'file',
        'status',
        'date_submitted',
        'study_type',
        'date_reviewed',      
        'abandoned_date',     
        'recovered_date',     
        'lost_date' 
    ];

    protected $casts = [
        'authors' => 'array',
        'citations' => 'array',
        'metadata' => 'array',
        'study_type' => 'array'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
