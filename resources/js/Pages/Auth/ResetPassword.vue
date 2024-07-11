<script setup>
import { Head } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

import GuestLayout from '@/Layouts/GuestLayout.vue'

import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
})

const form = useForm('post', route('password.store'), {
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

const submit = () => form.submit({
    onFinish: () => form.reset('password', 'password_confirmation'),
})
</script>

<template>
    <Head :title="$t('Reset your password')" />

    <GuestLayout>
        <Card class="mx-auto w-128">
            <CardHeader>
                <CardTitle class="text-xl">
                    {{ $t('Reset your password') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('Ensure your new password is at least 8 characters long, and contains at least one number and one uppercase letter and one symbol.') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">
                            {{ $t('Email') }}
                        </Label>

                        <Input
                            id="email"
                            type="email"
                            v-model="form.email"
                            @change="form.validate('email')"
                            autocomplete="username" />

                        <ErrorMessage v-if="form.invalid('email')">
                            {{ form.errors.email }}
                        </ErrorMessage>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2 content-start">
                            <Label for="password">
                                {{ $t('Password') }}
                            </Label>

                            <Input
                                v-model="form.password"
                                @change="form.validate('password')"
                                id="password"
                                type="password" />

                            <ErrorMessage v-if="form.invalid('password')">
                                {{ form.errors.password }}
                            </ErrorMessage>
                        </div>

                        <div class="grid gap-2 content-start">
                            <Label for="password_confirmation">
                                {{ $t('Password confirmation') }}
                            </Label>

                            <Input
                                v-model="form.password_confirmation"
                                @change="form.validate('password_confirmation')"
                                id="password_confirmation"
                                type="password" />

                            <ErrorMessage v-if="form.invalid('password_confirmation')">
                                {{ form.errors.password_confirmation }}
                            </ErrorMessage>
                        </div>
                    </div>

                    <Button :disabled="form.processing">
                        {{ $t('Reset password') }}
                    </Button>
                </form>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
