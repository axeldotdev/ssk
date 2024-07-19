<script setup>
import { Head } from '@inertiajs/vue3'

import ApplicationLogo from '@/components/ApplicationLogo.vue'

defineProps({
    policy: String,
})
</script>

<template>
    <Head :title="$t('Privacy Policy')" />

    <div class="flex flex-col gap-8 my-8 sm:max-w-2xl mx-auto">
        <ApplicationLogo class="h-16 w-auto fill-current text-neutral-800" />

        <div class="w-full prose prose-xl prose-h1:text-center prose-neutral" v-html="policy" />
    </div>
</template>
