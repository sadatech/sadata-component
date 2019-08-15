<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image;

if (! function_exists('get_company_name')) {
    function get_company_name()
    {
        return str_replace(' ', '_', auth()->user()->company->name);
    }
}

if (! function_exists('storage_upload')) {
    function storage_upload($companyFolder, $image = null, $imageOld = null)
    {
        if($image != null){

            $imageName = auth()->user()->id.'_'.time().'.jpg';        

            // CHECK DIRECTORY
            $path = str_replace('\\', '/', storage_path('app/public/'.$companyFolder));
            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);        

            Image::make($image)->orientate()->save($path.'/'.$imageName, 25);

            // return $path.$imageOld;

            // DELETE OLD IMAGE
            if($imageOld != null){
                $explodeImageOld = explode('/', $imageOld);
                File::delete($path.$explodeImageOld[count($explodeImageOld) - 1]);
            }

            return asset('storage').'/'.$companyFolder.$imageName;

        }else{

            return null;
            
        }
    }
}

if (! function_exists('storage_delete')) {
    function storage_delete($prevPath = null, $mode = null)
    {
        $path = str_replace('\\', '/', storage_path('app/public/'.$prevPath));

        if($prevPath != null){
            if($mode != null){

                if($mode == 'FILE'){
                    File::delete($path);
                }

                if($mode == 'DIRECTORY'){
                    File::deleteDirectory($path);
                }

                return 'TES';
            }
        }
    }
}

if (! function_exists('append_hidden')) {
    function append_hidden($model, $appends = [], $hiddens = [], $cud = null)
    {
        if($cud == null) $hiddens = array_merge($hiddens, ['created_at', 'updated_at', 'deleted_at']);

        $model->each(function ($item) use ($appends, $hiddens){
            return $item->append($appends)->setHidden($hiddens);
        });

        return $model;
    }
}

if (! function_exists('range_from_month')) {
    function range_from_month($monthYear = null)
    {
        if($monthYear == null){
            $monthYear = Carbon::now()->format('Y-m');
        }

        $monthYear = explode('-', $monthYear);

        $date1 = "$monthYear[0]-$monthYear[1]-01";
        $date2 = date('Y-m-d', strtotime('+1 month', strtotime($date1)));
        $date2 = date('Y-m-d', strtotime('-1 day', strtotime($date2)));
        $month = $monthYear[1];
        $year = $monthYear[0];

        return [ $date1, $date2, $month, $year ];
    }
}

if (! function_exists('url_to_route_name')) {
    function url_to_route_name($url, $method = 'GET')
    {
        return app('router')->getRoutes()->match(app('request')->create(str_replace(url('/'), '', $url), $method))->getName();
    }
}

if (! function_exists('currency_format')) {
    function currency_format($number = 0, $decimal = 0, $decimalSeparator = ',', $thousanSeparator = '.')
    {
        return number_format($number ?? 0, $decimal, $decimalSeparator, $thousanSeparator);
    }
}