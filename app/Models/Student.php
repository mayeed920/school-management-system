<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $table = 'students';

    protected $dates = [
        'date_of_birth',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'class_iid_id',
        'country_code_id',
        'date_of_birth',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function class_iid()
    {
        return $this->belongsTo(Clasess::class, 'class_iid_id');
    }

    public function country_code()
    {
        return $this->belongsTo(Country::class, 'country_code_id');
    }

    public function getDateOfBirthAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
