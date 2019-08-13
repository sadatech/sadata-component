<?php 

namespace Sada\SadataComponent\Traits;

trait DatatableFilter {

	public function filters($values)
    {
        foreach ($values as $method => $value) {
            if (!method_exists($this, $method) || empty($value)) {
                continue;
            }
            $this->$method($value);
        }
    }

}