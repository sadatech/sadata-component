<?php

namespace Sada\SadataComponent\Models;

use Sada\SadataComponent\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainModel extends BaseModel
{
	protected $connection = 'main';
}
