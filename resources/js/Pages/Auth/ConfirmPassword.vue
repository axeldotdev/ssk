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

const form = useForm('post', route('password.confirm'), {
    password: '',
})

const submit = () => form.submit({
    onFinish: () => form.reset(),
})
</script>

<template>
    <Head :title="$t('Confirm your password')" />

    <GuestLayout>
        <Card class="mx-auto w-128">
            <CardHeader>
                <CardTitle class="text-xl">
                    {{ $t('Confirm your password') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('This is a secure area of the application. Please confirm your password before continuing.') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="grid gap-4">
                    <div class="grid gap-2">
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

                    <Button :disabled="form.processing">
                        {{ $t('Confirm password') }}
                    </Button>
                </form>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
