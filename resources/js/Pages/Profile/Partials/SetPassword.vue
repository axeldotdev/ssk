<script setup>
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import { Card, CardContent, CardFooter } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'

const setPasswordForm = useForm('put', route('password.set'), {
    password: '',
    password_confirmation: '',
})

const submitSetPasswordForm = () => setPasswordForm.submit({
    preserveScroll: true,
})
</script>

<template>
<div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
    <div class="grid gap-2 text-sm">
        <h2 class="text-xl font-semibold text-neutral-800">
            {{ $t('Set password') }}
        </h2>
        <p class="text-neutral-500">
            {{ $t('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </div>
    <div class="grid gap-6">
        <Card>
            <CardContent class="pt-8">
                <form @submit.prevent="submitSetPasswordForm" class="grid gap-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2 content-start">
                            <Label for="password">
                                {{ $t('Password') }}
                            </Label>

                            <Input
                                v-model="setPasswordForm.password"
                                @change="setPasswordForm.validate('password')"
                                id="password"
                                type="password" />

                            <ErrorMessage v-if="setPasswordForm.invalid('password')">
                                {{ setPasswordForm.errors.password }}
                            </ErrorMessage>
                        </div>

                        <div class="grid gap-2 content-start">
                            <Label for="password_confirmation">
                                {{ $t('Password confirmation') }}
                            </Label>

                            <Input
                                v-model="setPasswordForm.password_confirmation"
                                @change="setPasswordForm.validate('password_confirmation')"
                                id="password_confirmation"
                                type="password" />

                            <ErrorMessage v-if="setPasswordForm.invalid('password_confirmation')">
                                {{ setPasswordForm.errors.password_confirmation }}
                            </ErrorMessage>
                        </div>
                    </div>
                </form>
            </CardContent>
            <CardFooter class="border-t px-6 py-4">
                <Button>
                    {{ $t('Save') }}
                </Button>
            </CardFooter>
        </Card>
    </div>
</div>
</template>
