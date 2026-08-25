<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center font-medium gap-2 rounded-lg transition bg-brand-500 text-white hover:bg-brand-600 px-5 py-2.5 text-sm shadow-theme-xs disabled:opacity-50 cursor-pointer']) }}>
    {{ $slot }}
</button>
