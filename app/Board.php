<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function comments() {
    	return $this->hasMany(Comment::class);
    }

    public function attachments() {
    	return $this->hasMany(Attachment::class);
    }
}
