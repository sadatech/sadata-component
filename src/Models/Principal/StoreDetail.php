<?php

namespace Sada\SadataComponent\Models\Principal;

use Illuminate\Database\Eloquent\Model;

class StoreDetail extends Store
{
    protected $appends = ['area_scope', 'channel_scope'];
    protected $hidden = ['area', 'channel'];

    public function getAreaScopeAttribute(){
    	$result = [];
		$area = $this->area;
		while (($area->parent_id ?? null) != null) {
			$result[] = [
				"field" => str_replace('-', '_', $area->header->slug_name)."_name",
				"value" => $area->name
			];
			$area = $area->parent;
		}

		if($area){
			$result[] = [
				"field" => str_replace('-', '_', $area->header->slug_name)."_name",
				"value" => $area->name
			];
		}

		return $result;
    }

    public function getChannelScopeAttribute(){
    	$result = [];
		$channel = $this->channel;
		while (($channel->parent_id ?? null) != null) {
			$result[] = [
				"field" => str_replace('-', '_', $channel->header->slug_name)."_name",
				"value" => $channel->name
			];
			$channel = $channel->parent;
		}

		if($channel){
			$result[] = [
				"field" => str_replace('-', '_', $channel->header->slug_name)."_name",
				"value" => $channel->name
			];
		}

		return $result;
    }
}
