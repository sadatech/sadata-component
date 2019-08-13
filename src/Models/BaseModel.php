<?php

namespace Sada\SadataComponent\Components;

use Sada\SadataComponent\Filters\QueryFilters;
// use Illuminate\Database\Eloquent\Model;
use Hoyvoy\CrossDatabase\Eloquent\Model as Model;

/**
 * 
 */
class BaseModel extends Model
{

	public function __construct(array $attributes = []){
		parent::__construct($attributes);
		parent::setPerPage(10);
	}

	public function isNewRecord()
	{
		return empty($this->id);
	}
	
	public function fillAndValidate($customData = null, $rule = null)
	{
		$rule = $rule ?? static::rule($this);
		$data = $customData ?? request()->all();
		$attributes = method_exists(static::class, 'attributes') ? static::attributes() : [];

		$validatedData = \Validator::make($data, $rule, [], $attributes)->validate();

		return parent::fill($validatedData);
	}

	/**
     * Filtering Berdasarakan Request User
     * @param $query
     * @param QueryFilters $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }

	public static function findBySlug($value, $field = 'name')
	{
		return static::where($field, str_replace('-', ' ', $value))->firstOrFail();
	}

	public function scopeSimple($query){
		return $query->simplePaginate(request()->limit_page)->appends(request()->all());
	}
}