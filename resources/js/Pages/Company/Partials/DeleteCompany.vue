<script setup>
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardFooter } from '@/components/ui/card'
</script>

<template>
    <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
        <div class="grid gap-2 text-sm">
            <h2 class="text-xl font-semibold text-neutral-800">
                {{ $t('Delete company') }}
            </h2>
            <p class="text-neutral-500">
                {{ $t('Delete your company and all of its resources.') }}
            </p>
        </div>
        <div class="grid gap-6">
            <Card>
                <CardContent class="pt-8">
                    <p class="text-sm">
                        {{ $t('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                    </p>
                </CardContent>
                <CardFooter class="border-t px-6 py-4">
                    <Button variant="destructive">
                        {{ $t('Delete company') }}
                    </Button>
                </CardFooter>
            </Card>
        </div>
    </div>
</template>
