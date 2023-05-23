<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Tests\Events\TestsEvent;
use Modules\Tests\Listeners\TestsListener;
use Modules\Companies\Events\CompaniesEvent;
use Modules\Companies\Listeners\CompaniesListener;
use Modules\Units\Events\UnitsEvent;
use Modules\Units\Listeners\UnitsListener;
use Modules\UnitConverters\Events\UnitConvertersEvent;
use Modules\UnitConverters\Listeners\UnitConvertersListener;
use Modules\Categories\Events\CategoriesEvent;
use Modules\Categories\Listeners\CategoriesListener;
use Modules\Items\Events\ItemsEvent;
use Modules\Items\Listeners\ItemsListener;
// Namespaces

class EventServiceProvider extends ServiceProvider
{
        /**
         * The event listener mappings for the application.
         *
         * @var array
         */
        protected $listen = [
                Registered::class => [
                        SendEmailVerificationNotification::class,
                        // Listeners
                ],

                // TestsEvent
                TestsEvent::class => [
                        TestsListener::class,
                        TestsListener::class,
                        TestsListener::class,
                        // TestsEvent listeners
                ],

                // CompaniesEvent
                CompaniesEvent::class => [
                        CompaniesListener::class,
                        // CompaniesEvent listeners
                ],

                // UnitsEvent
                UnitsEvent::class => [
                        UnitsListener::class,
                        // UnitsEvent listeners
                ],

                // UnitConvertersEvent
                UnitConvertersEvent::class => [
                        UnitConvertersListener::class,
                        // UnitConvertersEvent listeners
                ],

                // CategoriesEvent
                CategoriesEvent::class => [
                        CategoriesListener::class,
                        // CategoriesEvent listeners
                ],

                // ItemsEvent
                ItemsEvent::class => [
                        ItemsListener::class,
                        // ItemsEvent listeners
                ],

                // TestsEvent
                TestsEvent::class => [
                        TestsListener::class,
                        TestsListener::class,
                        // TestsEvent listeners
                ],

                // TestsEvent
                TestsEvent::class => [
                        TestsListener::class,
                        // TestsEvent listeners
                ],

                // Events
        ];

        /**
         * Register any events for your application.
         *
         * @return void
         */
        public function boot()
        {
                //
        }
}
