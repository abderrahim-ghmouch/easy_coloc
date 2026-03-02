<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-primary hover:bg-primary/90 text-background-dark font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-background-dark']) }}>
    {{ $slot }}
</button>
