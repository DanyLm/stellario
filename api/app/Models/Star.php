<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'description',
        'face',
        'popularity'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'face' => 'json'
    ];

    /**
     * toArray
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'face' => json_decode($this->face, true),
            'description' => $this->description,
            'popularity' => $this->popularity,
            'updated_at' => $this->updated_at->format('d/m/Y à H:i')
        ];
    }
}
