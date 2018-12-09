<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	protected $fillable = ['filename', 'bytes', 'mime'];
    //
    public function board() {
    	return $this->belongsTo(Board::class);
    }
}
