<?php

namespace YKuadrat\FormBuilder;

use Collective\Html\FormFacade;
use Illuminate\Support\ServiceProvider;

class FormBuilderProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        FormFacade::component('fileInput', 'form-builder::file_input', ['name', 'value', 'attributes']);
        FormFacade::component('textInput', 'form-builder::text_input', ['name', 'value', 'attributes']);
        FormFacade::component('passwordInput', 'form-builder::password_input', ['name', 'value', 'attributes']);
        FormFacade::component('emailInput', 'form-builder::email_input', ['name', 'value', 'attributes']);
        FormFacade::component('textareaInput', 'form-builder::textarea_input', ['name', 'value', 'attributes']);
        FormFacade::component('dateInput', 'form-builder::date_input', ['name', 'value', 'attributes']);
        FormFacade::component('numberInput', 'form-builder::number_input', ['name', 'value', 'attributes']);
        FormFacade::component('radioInput', 'form-builder::radio_input', ['name', 'value', 'options' => [1 => 'yes', 0 => 'no'], 'attributes']);
        FormFacade::component('selectInput', 'form-builder::select_input', ['name', 'value', 'options' => [], 'attributes']);
        FormFacade::component('switchInput', 'form-builder::switch_input', ['name', 'value' => 1, 'attributes']);
        FormFacade::component('multipleInput', 'form-builder::multiple_input', ['name', 'type', 'values' => [''], 'attributes']);
        FormFacade::component('multipleColumnInput', 'form-builder::multiple_column_input', ['name', 'values' => [], 'columns', 'attributes']);
        FormFacade::component('select2Input', 'form-builder::select2_input', ['name', 'value', 'options' => [], 'attributes']);
        FormFacade::component('select2MultipleInput', 'form-builder::select2_multiple_input', ['name', 'value', 'options' => [], 'attributes']);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViews();
    }

    private function loadViews()
    {
        $viewsPath = $this->packagePath('resources' . DIRECTORY_SEPARATOR . 'views');
        $this->loadViewsFrom($viewsPath, 'sadata');

        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/sadata-component'),
        ], 'views');
    }

    private function packagePath($path)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path;
    }
}
