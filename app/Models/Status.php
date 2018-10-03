<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'status_code'
    ];

    /**
    * Checking if status up
    *
    * @return void
    */
    public function isUp ()
    {
        return substr((string) $this->status_code, 0, 1) === '2';
    }

    /**
    * Checking if status up is down
    *
    * @return void
    */
    public function isDown ()
    {
        return !$this->isUp();
    }
}


?>