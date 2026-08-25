@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-3.5 mb-4 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-300']) }}>
        {{ $status }}
    </div>
@endif
