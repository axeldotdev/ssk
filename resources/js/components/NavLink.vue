<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    href: {
        type: String,
        required: true,
    },
    isActive: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <Link :href="href" :class="[isActive ? 'bg-neutral-800 text-neutral-50' : 'hover:bg-neutral-100 hover:text-neutral-900 dark:hover:bg-neutral-800 dark:hover:text-neutral-50', 'inline-flex items-center justify-start whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors select-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 dark:ring-offset-neutral-950 dark:focus-visible:ring-neutral-300 h-10 px-4 py-2']">
        <slot />
    </Link>
</template>
