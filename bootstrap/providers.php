<?php

return [
    App\Providers\AppServiceProvider::class,
    // Provider Regency
    AzisHapidin\IndoRegion\IndoRegionServiceProvider::class,
    RealRashid\SweetAlert\SweetAlertServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    Clockwork\Support\Laravel\ClockworkServiceProvider::class,
    Irfa\SerialNumber\SerialNumberGeneratorSeviceProvider::class,
    Yajra\DataTables\DataTablesServiceProvider::class,
    Maatwebsite\Excel\ExcelServiceProvider::class,
    Anhskohbo\NoCaptcha\NoCaptchaServiceProvider::class,
    Barryvdh\DomPDF\ServiceProvider::class,
];
