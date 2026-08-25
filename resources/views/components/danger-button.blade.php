<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center font-medium gap-2 rounded-lg transition bg-error-500 text-white hover:bg-error-600 px-4 py-2 text-sm shadow-theme-xs disabled:opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>
