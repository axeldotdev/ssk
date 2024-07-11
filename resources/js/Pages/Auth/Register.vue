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

import RegisterEmail from '@/Pages/Auth/Partials/RegisterEmail.vue'
import RegisterPhone from '@/Pages/Auth/Partials/RegisterPhone.vue'

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
    socialstream: {
        type: Object,
    },
    errors: {
        type: Object,
    },
})

const signUpMethod = ref(null)
</script>

<template>
    <Head :title="$t('Sign up')" />

    <GuestLayout>
        <Card class="mx-auto w-128">
            <CardHeader>
                <CardTitle class="text-xl">
                    {{ $t('Sign up') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('Select a sign up method below.') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div v-if="signUpMethod === null" class="grid gap-4">
                    <Button
                        v-if="signViaEmail"
                        @click="signUpMethod = 'email'"
                        type="button"
                        class="w-full">
                        {{ $t('Continue with Email') }}
                    </Button>

                    <Button
                        v-if="signViaPhone"
                        @click="signUpMethod = 'phone'"
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
                        class="w-full">
                        <a :href="route('oauth.redirect', provider.id)">
                            {{ $t(provider.buttonLabel) }}
                        </a>
                    </Button>
                </div>

                <RegisterEmail
                    v-if="signViaEmail && signUpMethod === 'email'"
                    @back="signUpMethod = null">
                </RegisterEmail>

                <RegisterPhone
                    v-if="signViaPhone && signUpMethod === 'phone'"
                    @back="signUpMethod = null">
                </RegisterPhone>

                <div class="mt-4 text-center text-sm">
                    {{ $t('Already registered?') }}
                    <Link :href="route('login')" class="underline">
                        {{ $t('Sign in') }}
                    </Link>
                </div>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
