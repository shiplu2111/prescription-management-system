<?php

namespace App\Providers\Filament;
use App\Http\Middleware\CheckUserRole;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationGroup;
use App\Filament\Auth\CustomLogin;
use App\Filament\Resources\InvestigationResource;
use App\Filament\Resources\MedicineResource;
use App\Filament\Resources\ChiefComplaintResource;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\MenuItem;
use App\Filament\Doctor\Resources\ProfileResource;


class DoctorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('doctor')
            ->path('doctor')
            ->login(CustomLogin::class)
            ->sidebarFullyCollapsibleOnDesktop()
            // ->topNavigation()
            ->sidebarWidth('14rem')
            ->colors([
                'primary' => Color::Amber,
            ])
             ->resources([
                InvestigationResource::class, // Admin can see users
                MedicineResource::class,
                ChiefComplaintResource::class,
            ])
            ->discoverResources(in: app_path('Filament/Doctor/Resources'), for: 'App\\Filament\\Doctor\\Resources')
            ->discoverPages(in: app_path('Filament/Doctor/Pages'), for: 'App\\Filament\\Doctor\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Doctor/Widgets'), for: 'App\\Filament\\Doctor\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])

            ->middleware([

                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                CheckUserRole::class . ':doctor',
            ])


            ->navigationGroups([
            NavigationGroup::make()
                ->label('Patient')
                ->collapsed(),
            NavigationGroup::make()
                ->label('Settings')
                ->collapsed(),

        ])
        ->userMenuItems([
    MenuItem::make()
        ->label('Profile')
        ->url(function (): string {
            $profile = \App\Models\Profile::where('user_id', auth()->id())->first();

            return $profile
                ? \App\Filament\Doctor\Resources\ProfileResource::getUrl('edit', ['record' => $profile])
                : \App\Filament\Doctor\Resources\ProfileResource::getUrl('create');
        })
        ->icon('heroicon-o-user-circle'),
]);
    }
}
