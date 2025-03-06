<?php

namespace App\Modules\Auth\ApiKey;

use App\Modules\User\User;
use App\Support\Eloquent\CamelCasing;
use App\Support\Eloquent\ForceMake;
use App\Support\Eloquent\HasStringId;
use App\Support\Eloquent\StaticTableName;
use App\Support\Eloquent\Unguarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use CamelCasing, ForceMake, HasFactory, HasStringId, StaticTableName, Unguarded;
    protected $dates = [
        'expires_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function setValueAttribute(string $value) {
        $this->attributes['value'] = encrypt($value);
        $this->attributes['hash'] = hash('sha256', $value);
    }

    public function getValueAttribute() {
        return !empty($this->attributes['value']) ? decrypt($this->attributes['value']) : null;
    }
}
