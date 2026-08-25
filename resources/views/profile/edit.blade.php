<x-app-layout>
    <x-slot name="title">Profile Settings</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Profile Settings</h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your account information, security credentials, and preferences</p>
        </div>

        <div class="p-6 sm:p-8 bg-white dark:bg-gray-dark border border-gray-200 dark:border-gray-800 shadow-theme-xs rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-white dark:bg-gray-dark border border-gray-200 dark:border-gray-800 shadow-theme-xs rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-white dark:bg-gray-dark border border-gray-200 dark:border-gray-800 shadow-theme-xs rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
