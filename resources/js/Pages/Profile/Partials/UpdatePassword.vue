<script setup>
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import { Card, CardContent, CardFooter } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'

const updatePasswordForm = useForm('put', route('password.update'), {
    current_password: '',
    password: '',
    password_confirmation: '',
})

const submitUpdatePasswordForm = () => updatePasswordForm.submit({
    preserveScroll: true,
})
</script>

<template>
    <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
        <div class="grid gap-2 text-sm">
            <h2 class="text-xl font-semibold text-neutral-800">
                {{ $t('Update password') }}
            </h2>
            <p class="text-neutral-500">
                {{ $t('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>
        <div class="grid gap-6">
            <Card>
                <CardContent class="pt-8">
                    <form @submit.prevent="submitUpdatePasswordForm" class="grid gap-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="grid gap-2 content-start">
                                <Label for="current_password">
                                    {{ $t('Current password') }}
                                </Label>

                                <Input
                                    v-model="updatePasswordForm.current_password"
                                    @change="updatePasswordForm.validate('current_password')"
                                    id="current_password"
                                    type="password" />

                                <ErrorMessage v-if="updatePasswordForm.invalid('current_password')">
                                    {{ updatePasswordForm.errors.current_password }}
                                </ErrorMessage>
                            </div>

                            <div class="grid gap-2 content-start">
                                <Label for="password">
                                    {{ $t('New password') }}
                                </Label>

                                <Input
                                    v-model="updatePasswordForm.password"
                                    @change="updatePasswordForm.validate('password')"
                                    id="password"
                                    type="password" />

                                <ErrorMessage v-if="updatePasswordForm.invalid('password')">
                                    {{ updatePasswordForm.errors.password }}
                                </ErrorMessage>
                            </div>

                            <div class="grid gap-2 content-start">
                                <Label for="password_confirmation">
                                    {{ $t('Password confirmation') }}
                                </Label>

                                <Input
                                    v-model="updatePasswordForm.password_confirmation"
                                    @change="updatePasswordForm.validate('password_confirmation')"
                                    id="password_confirmation"
                                    type="password" />

                                <ErrorMessage v-if="updatePasswordForm.invalid('password_confirmation')">
                                    {{ updatePasswordForm.errors.password_confirmation }}
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
