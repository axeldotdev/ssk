<script setup>
import { Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'

const emit = defineEmits(['back'])

const emailForm = useForm('post', route('login'), {
    email: '',
    password: '',
    remember: false,
})

const submitEmailForm = () => emailForm.submit({
    onFinish: () => emailForm.reset('password'),
})

const back = () => emit('back')
</script>

<template>
    <form
        @submit.prevent="submitEmailForm"
        class="grid gap-4">
        <div class="grid gap-2">
            <Label for="email">
                {{ $t('Email') }}
            </Label>

            <Input
                v-model="emailForm.email"
                @change="emailForm.validate('email')"
                id="email"
                type="email"
                placeholder="support@orvea.io"
                autocomplete="username" />

            <ErrorMessage v-if="emailForm.invalid('email')">
                {{ emailForm.errors.email }}
            </ErrorMessage>
        </div>

        <div class="grid gap-2">
            <div class="flex items-center">
                <Label for="password">
                    {{ $t('Password') }}
                </Label>

                <Link
                    :href="route('password.request')"
                    class="ml-auto inline-block text-sm underline">
                    {{ $t('Forgot your password?') }}
                </Link>
            </div>

            <Input
                v-model="emailForm.password"
                @change="emailForm.validate('password')"
                id="password"
                type="password" />

            <ErrorMessage v-if="emailForm.invalid('password')">
                {{ emailForm.errors.password }}
            </ErrorMessage>
        </div>

        <div class="flex items-center space-x-2">
            <Checkbox v-model:checked="emailForm.remember" id="remember" />
            <Label for="remember">
                {{ $t('Remember me') }}
            </Label>
        </div>

        <Button :disabled="emailForm.processing" type="submit">
            {{ $t('Sign in') }}
        </Button>

        <Button @click="back" type="button" variant="outline">
            {{ $t('Back') }}
        </Button>
    </form>
</template>
