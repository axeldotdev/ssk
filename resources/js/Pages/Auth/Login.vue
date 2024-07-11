<script setup>
import { ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'

import GuestLayout from '@/Layouts/GuestLayout.vue'

import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'

import LoginEmail from '@/Pages/Auth/Partials/LoginEmail.vue'
import LoginPhone from '@/Pages/Auth/Partials/LoginPhone.vue'

defineProps({
    signViaEmail: {
        type: Boolean,
    },
    signViaPhone: {
        type: Boolean,
    },
    signViaSSO: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    socialstream: {
        type: Object,
    },
    errors: {
        type: Object,
    },
})

const signInMethod = ref(null)
</script>

<template>
    <Head :title="$t('Sign in')" />

    <GuestLayout>
        <Card class="mx-auto w-128">
            <CardHeader>
                <CardTitle class="text-xl">
                    {{ $t('Sign in') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('Select a sign in method below.') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div v-if="signInMethod === null" class="grid gap-4">
                    <Button
                        v-if="signViaEmail"
                        @click="signInMethod = 'email'"
                        type="button"
                        class="w-full">
                        {{ $t('Continue with Email') }}
                    </Button>

                    <Button
                        v-if="signViaPhone"
                        @click="signInMethod = 'phone'"
                        variant="outline"
                        type="button"
                        class="w-full">
                        {{ $t('Continue with Phone') }}
                    </Button>

                    <Button
                        v-if="signViaSSO"
                        v-for="provider in socialstream.providers"
                        :key="provider.id"
                        variant="outline"
                        as-child
                        lass="w-full">
                        <a :href="route('oauth.redirect', provider.id)">
                            {{ $t(provider.buttonLabel) }}
                        </a>
                    </Button>
                </div>

                <LoginEmail
                    v-if="signViaEmail && signInMethod === 'email'"
                    @back="signInMethod = null">
                </LoginEmail>

                <LoginPhone
                    v-if="signViaPhone && signInMethod === 'phone'"
                    @back="signInMethod = null">
                </LoginPhone>

                <div class="mt-4 text-center text-sm">
                    {{ $t("Don't have an account?") }}
                    <Link :href="route('register')" class="underline">
                        {{ $t('Sign up') }}
                    </Link>
                </div>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
