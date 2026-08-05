<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EducationLevel extends Model
{
    protected $table = 'education_levels';
    protected $fillable = ['name', 'slug', 'image', 'tagline', 'program', 'order', 'whatsapp_number', 'show_extracurriculars'];

    public function facilities(): HasMany
    {
        return $this->hasMany(Facility::class)->orderBy('order');
    }

    public function classStats(): HasMany
    {
        return $this->hasMany(ClassStat::class)->orderBy('order');
    }

    public function extracurriculars(): HasMany
    {
        return $this->hasMany(Extracurricular::class)->orderBy('order');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class)->orderBy('order');
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class)->orderBy('order');
    }

    // Case-insensitive route model binding
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field === 'slug') {
            return $this->where('slug', strtolower($value))->firstOrFail();
        }

        return parent::resolveRouteBinding($value, $field);
    }

    // WhatsApp message accessor
    public function getWhatsappUrlAttribute(): string
    {
        $waNumber = $this->whatsapp_number ?: SchoolSetting::current()->whatsapp_number;
        $message = "Assalamu'alaikum, saya ingin mendaftarkan anak saya di jenjang {$this->name} Darul Fikri.";
        return "https://wa.me/{$waNumber}?text=" . urlencode($message);
    }
}
