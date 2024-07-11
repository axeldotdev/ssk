<script setup>
import { usePage } from '@inertiajs/vue3'

import { Toaster } from '@/components/ui/sonner'

import ApplicationLogo from '@/components/ApplicationLogo.vue'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'

const locales = usePage().props.locales

const changeLocale = (value) => localStorage.setItem('locale', value)
</script>

<template>
    <div class="isolate flex flex-col justify-center items-center w-full h-screen gap-8 bg-neutral-50">
        <ApplicationLogo class="w-20 h-20" />

        <slot />

        <div class="w-40">
            <Select v-model="$i18n.locale" @update:modelValue="changeLocale">
                <SelectTrigger>
                    <SelectValue placeholder="Select a locale" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem v-for="(locale, index) in locales" :key="index" :value="index">
                        {{ locale }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>
    </div>

    <Toaster />
</template>
