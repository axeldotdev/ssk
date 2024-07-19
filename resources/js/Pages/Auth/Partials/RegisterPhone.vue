<script setup>
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'

const emit = defineEmits(['back'])

const phoneForm = useForm('post', route('register'), {
    firstname: '',
    lastname: '',
    phone: '',
    terms: false,
})

const submitPhoneForm = () => phoneForm.submit({
    onFinish: () => phoneForm.reset('password'),
})

const back = () => emit('back')
</script>

<template>
    <form
        @submit.prevent="submitPhoneForm"
        class="grid gap-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="grid gap-2 content-start">
                <Label for="firstname">
                    {{ $t('Firstname') }}
                </Label>

                <Input
                    v-model="phoneForm.firstname"
                    @change="phoneForm.validate('firstname')"
                    id="firstname"
                    placeholder="John"
                    autocomplete="firstname" />

                <ErrorMessage v-if="phoneForm.invalid('firstname')">
                    {{ phoneForm.errors.firstname }}
                </ErrorMessage>
            </div>

            <div class="grid gap-2 content-start">
                <Label for="lastname">
                    {{ $t('Lastname') }}
                </Label>

                <Input
                    v-model="phoneForm.lastname"
                    @change="phoneForm.validate('lastname')"
                    id="lastname"
                    placeholder="Doe"
                    autocomplete="lastname" />

                <ErrorMessage v-if="phoneForm.invalid('lastname')">
                    {{ phoneForm.errors.lastname }}
                </ErrorMessage>
            </div>
        </div>

        <div class="grid gap-2">
            <Label for="phone">
                {{ $t('Phone') }}
            </Label>

            <Input
                v-model="phoneForm.phone"
                @change="phoneForm.validate('phone')"
                id="phone"
                type="tel"
                autocomplete="phone" />

            <ErrorMessage v-if="phoneForm.invalid('phone')">
                {{ phoneForm.errors.phone }}
            </ErrorMessage>
        </div>

        <div class="flex items-center space-x-2">
            <Checkbox v-model:checked="phoneForm.terms" id="terms" />
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

        <Button :disabled="phoneForm.processing" class="w-full">
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
