<?php

namespace App;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class RapprochementBancaire extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Auditable;

    protected $appends = [
        'statut',
    ];

    public $table = 'rapprochement_bancaires';

    protected $dates = [
        'du',
        'au',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'du',
        'au',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function getStatutAttribute()
    {
        return $this->getMedia('statut');
    }

    public function getDuAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDuAttribute($value)
    {
        $this->attributes['du'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getAuAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setAuAttribute($value)
    {
        $this->attributes['au'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
