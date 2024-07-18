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
                {{ $t('I accept the terms and conditions') }}
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
