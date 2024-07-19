<script setup>
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'

const emit = defineEmits(['back'])

const emailForm = useForm('post', route('register'), {
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
})

const submitEmailForm = () => emailForm.submit({
    onFinish: () => emailForm.reset('password', 'password_confirmation'),
})

const back = () => emit('back')
</script>

<template>
    <form
        @submit.prevent="submitEmailForm"
        class="grid gap-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="grid gap-2 content-start">
                <Label for="firstname">
                    {{ $t('Firstname') }}
                </Label>

                <Input
                    v-model="emailForm.firstname"
                    @change="emailForm.validate('firstname')"
                    id="firstname"
                    placeholder="John"
                    autocomplete="firstname" />

                <ErrorMessage v-if="emailForm.invalid('firstname')">
                    {{ emailForm.errors.firstname }}
                </ErrorMessage>
            </div>

            <div class="grid gap-2 content-start">
                <Label for="lastname">
                    {{ $t('Lastname') }}
                </Label>

                <Input
                    v-model="emailForm.lastname"
                    @change="emailForm.validate('lastname')"
                    id="lastname"
                    placeholder="Doe"
                    autocomplete="lastname" />

                <ErrorMessage v-if="emailForm.invalid('lastname')">
                    {{ emailForm.errors.lastname }}
                </ErrorMessage>
            </div>
        </div>

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

        <div class="grid grid-cols-2 gap-4">
            <div class="grid gap-2 content-start">
                <Label for="password">
                    {{ $t('Password') }}
                </Label>

                <Input
                    v-model="emailForm.password"
                    @change="emailForm.validate('password')"
                    id="password"
                    type="password" />

                <ErrorMessage v-if="emailForm.invalid('password')">
                    {{ emailForm.errors.password }}
                </ErrorMessage>
            </div>

            <div class="grid gap-2 content-start">
                <Label for="password_confirmation">
                    {{ $t('Password confirmation') }}
                </Label>

                <Input
                    v-model="emailForm.password_confirmation"
                    @change="emailForm.validate('password_confirmation')"
                    id="password_confirmation"
                    type="password" />

                <ErrorMessage v-if="emailForm.invalid('password_confirmation')">
                    {{ emailForm.errors.password_confirmation }}
                </ErrorMessage>
            </div>
        </div>

        <div class="flex space-x-2">
            <Checkbox v-model:checked="emailForm.terms" id="terms" class="mt-0.5" />
            <Label for="terms">
                <i18n-t keypath="I agree to the {Terms} and {Policy}" tag="span">
                    <template v-slot:Terms>
                        <a target="_blank" :href="route('terms.show')" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors select-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 dark:ring-offset-neutral-950 dark:focus-visible:ring-neutral-300 text-neutral-900 underline-offset-4 hover:underline dark:text-neutral-50">
                            {{ $t('Terms of service') }}
                        </a>
                    </template>
                    <template v-slot:Policy>
                        <a target="_blank" :href="route('policy.show')" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors select-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-neutral-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 dark:ring-offset-neutral-950 dark:focus-visible:ring-neutral-300 text-neutral-900 underline-offset-4 hover:underline dark:text-neutral-50">
                            {{ $t('Privacy policy') }}
                        </a>
                    </template>
                </i18n-t>
            </Label>
        </div>

        <Button :disabled="emailForm.processing" class="w-full">
            {{ $t('Sign up') }}
        </Button>

        <Button
            @click="back"
            type="button"
            variant="outline"
            class="w-full">
            {{ $t('Back') }}
        </Button>
    </form>
</template>
