<script setup>
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'

import ProviderIcon from '@/components/ProviderIcon.vue';

const props = defineProps({
    socialstream: {
        type: Object,
    },
})

const hasAccountForProvider = (provider) => props.socialstream.connectedAccounts
    .filter(account => account.provider === provider.id)
    .shift() !== undefined;

const getAccountForProvider = (provider) => props.socialstream.connectedAccounts
    .filter(account => account.provider === provider.id)
    .shift();
</script>

<template>
    <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
        <div class="grid gap-2 text-sm">
            <h2 class="text-xl font-semibold text-neutral-800">
                {{ $t('Manage connected accounts') }}
            </h2>
            <p class="text-neutral-500">
                {{ $t('Connect or disconnect your account from third-party services.') }}
            </p>
        </div>
        <div class="grid gap-6">
            <Card>
                <CardContent class="pt-8">
                    <p class="text-sm text-neutral-600">
                        {{ $t('If you feel any of your connected accounts have been compromised, you should disconnect them immediately and change your password.') }}
                    </p>
                    <div class="mt-4">
                        <template v-for="provider in socialstream.providers" :key="provider.id">
                            <div>
                                <div class="p-3 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <ProviderIcon :provider="provider" classes="h-6 w-6 me-2" />

                                        <div class="ms-2">
                                            <div class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">
                                                {{ provider.name }}
                                            </div>

                                            <div
                                                v-if="(hasAccountForProvider(provider) ? getAccountForProvider(provider)?.created_at : '') !== null"
                                                class="text-xs text-neutral-500">
                                                {{ $t('Connected') }} {{ hasAccountForProvider(provider) ? getAccountForProvider(provider)?.created_at : '' }}
                                            </div>

                                            <div v-else class="text-xs text-neutral-500">
                                                {{ $t('Not connected') }}
                                            </div>
                                        </div>
                                    </div>

                                    <template v-if="hasAccountForProvider(provider)">
                                        <Button v-if="socialstream.connectedAccounts.length > 1 || hasPassword"
                                            @click="confirmAccountRemoval(provider)"
                                            variant="destructive">
                                            {{ $t('Remove') }}
                                        </Button>
                                    </template>

                                    <template v-else>
                                        <Button variant="outline" as-child>
                                            <a :href="route('oauth.redirect', { provider })">
                                                {{ $t('Connect') }}
                                            </a>
                                        </Button>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
