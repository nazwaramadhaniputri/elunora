<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agenda';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'status',
        'kategori',
        'catatan'
    ];

    protected $appends = [
        'tanggal_formatted',
        'waktu_formatted',
        'is_past',
        'is_today'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
    ];

    /**
     * Scope a query to only include published agendas.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include upcoming agendas.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', Carbon::today());
    }

    /**
     * Scope a query to only include today's agendas.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    /**
     * Get the formatted date attribute.
     */
    public function getTanggalFormattedAttribute()
    {
        return $this->tanggal ? $this->tanggal->isoFormat('dddd, D MMMM Y') : '';
    }

    /**
     * Get the formatted time range attribute.
     */
    public function getWaktuFormattedAttribute()
    {
        if (!$this->waktu_mulai) {
            return '';
        }

        $start = Carbon::parse($this->waktu_mulai)->format('H:i');
        
        if ($this->waktu_selesai) {
            return $start . ' - ' . Carbon::parse($this->waktu_selesai)->format('H:i');
        }
        
        return $start;
    }

    /**
     * Check if the agenda is in the past.
     */
    public function getIsPastAttribute()
    {
        if (!$this->tanggal) {
            return false;
        }
        
        $agendaDate = $this->tanggal->format('Y-m-d');
        $endTime = $this->waktu_selesai ?: $this->waktu_mulai;
        
        if ($endTime) {
            $agendaDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s', 
                $agendaDate . ' ' . $endTime->format('H:i:s')
            );
            return $agendaDateTime->isPast();
        }
        
        // If no time is set, consider it as end of day
        $agendaDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $agendaDate . ' 23:59:59');
        return $agendaDateTime->isPast();
    }
    
    /**
     * Check if the agenda is today.
     */
    public function getIsTodayAttribute()
    {
        return $this->tanggal && $this->tanggal->isToday();
    }
}
