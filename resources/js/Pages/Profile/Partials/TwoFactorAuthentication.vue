<script setup>
import { Card, CardContent } from '@/components/ui/card'
</script>

<template>
    <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
        <div class="grid gap-2 text-sm">
            <h2 class="text-xl font-semibold text-neutral-800">
                {{ $t('Manage your two factor authentication') }}
            </h2>
            <p class="text-neutral-500">
                {{ $t('Remember to save your recovery codes.') }}
            </p>
        </div>
        <div class="grid gap-6">
            <Card>
                <CardContent class="pt-8">
                </CardContent>
            </Card>
        </div>
    </div>
</template>
