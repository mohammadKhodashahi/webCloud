<?php

namespace App\Models;

use App\Models\Concerns\HumanReadable;
use App\Models\Concerns\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFiles
 * @package App\Models
 * @property string $id
 * @property string name
 * @property int $user_id
 * @property string $format
 * @property float $size
 */
class UserFiles extends Model
{
    const FILE_UPLOAD_FOLDER = 'app/file/';
    use HasFactory;
    use UsesUuid;
    use HumanReadable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'size',
        'format',
        'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'account_id');
    }

    public function getServerFileName(): string
    {
        return $this->id . "." . $this->format;
    }

    /**
     * @param bool $humanReadable
     * @return float|string
     */
    public function getFileSize($humanReadable = false)
    {
        if ($humanReadable) {
            return $this->humanReadableSize();
        }
        return $this->size;
    }

}
