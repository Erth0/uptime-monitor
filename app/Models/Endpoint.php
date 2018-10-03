<?php 

namespace App\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    protected $fillable = [
        'uri', 
        'frequency'
    ];

    /**
     * Get the statuses for the Endpoint.
     *
     * @return App\Models\Status | Collection
     */
    public function statuses()
    {
        return $this->hasMany(Status::class, 'endpoint_id', 'id')->orderBy('created_at', 'desc');
    }

    /**
     * Get the status record associated with the Endpoint Model.
     *
     * @return App\Models\Status | Collection
     */
    public function status()
    {
        return $this->hasOne(Status::class, 'endpoint_id', 'id')->orderBy('created_at', 'desc');
    }

    /**
    * Public Method isBackUp
    *
    * @return void
    */
    public function isBackUp ()
    {
        return $this->status->isUp() && ($this->statuses->get(1) && $this->statuses->get(1)->isDown());
    }
}


?>