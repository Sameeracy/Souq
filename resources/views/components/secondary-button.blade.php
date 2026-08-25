<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center font-medium gap-2 rounded-lg transition border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 px-4 py-2 text-sm shadow-theme-xs disabled:opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>
