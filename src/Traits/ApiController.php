<?php

namespace Sada\SadataComponent\Traits;

trait ApiController {

	public function res($data = [])
    {
        $res = collect(['status' => true]);

        if (!($data instanceof Collection)) {
            $data = collect($data);
        }

        return $res->merge($data);
    }

    public function sendRes($data = [], $code = 200)
    {
        return response()->json($this->res($data), $code);
    }

}
