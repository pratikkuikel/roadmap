<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>
    <x-main full-width>
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">
            <x-app-brand class="p-5 pt-3" />
            <x-menu activate-by-route>
                @if ($user = auth()->user())
                    <x-list-item :item="$user" sub-value="username" no-separator no-hover
                        class="!-mx-2 mt-2 mb-5 border-y border-y-sky-900">
                        <x-slot:actions>
                            <x-theme-toggle class="hidden" />
                            <x-button tooltip="change mode" icon="o-moon" @click="$dispatch('mary-toggle-theme')" />
                            <x-button icon="o-power" link="{{ route('logout') }}" class="btn-circle btn-ghost btn-xs"
                                tooltip-left="logout" />
                        </x-slot:actions>
                    </x-list-item>
                @endif
                @guest
                    <x-theme-toggle class="hidden" />
                    <x-button tooltip="change mode" icon="o-moon" @click="$dispatch('mary-toggle-theme')" />
                @endguest
                <x-menu-item title="Roadmap" icon="o-bolt" link="{{ route('roadmap') }}" />
                @guest
                    <x-menu-item title="Login" icon="o-lock-closed" link="{{ route('login') }}" />
                    <x-menu-item title="Register" icon="o-plus" link="{{ route('register') }}" />
                @endguest
            </x-menu>
        </x-slot:sidebar>
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>
    <x-toast />
</body>

</html>
