<script setup>
import GoogleIcon from '@/components/GoogleIcon.vue';
import MicrosoftIcon from '@/components/MicrosoftIcon.vue';

defineProps({
    provider: {
        type: Object
    },
    classes: {
        type: String,
    }
});
</script>

<template>
    <div class="text-gray-900 dark:text-gray-100">
        <GoogleIcon v-if="provider.id === 'google'" :class="classes"/>
        <MicrosoftIcon v-if="provider.id === 'microsoft'" :class="classes"/>
    </div>
</template>
