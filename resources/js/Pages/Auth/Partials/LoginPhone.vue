<script setup>
import { defineEmits, ref } from 'vue'
import { useForm } from 'laravel-precognition-vue-inertia'

import { toast } from 'vue-sonner'

import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
    PinInput,
    PinInputGroup,
    PinInputInput,
} from '@/components/ui/pin-input'

import ErrorMessage from '@/components/ErrorMessage.vue'

const emit = defineEmits(['back'])

const verificationCodeSent = ref(false)

const phoneForm = useForm('post', route('login'), {
    phone: '',
    password: [],
    remember: false,
})

const verificationForm = useForm('post', route('phone-verification.send'), {
    phone: '',
})

const submitPhoneForm = () => phoneForm.transform((data) => ({
    ...data,
    password: data.password.join(''),
})).submit({
    onFinish: () => phoneForm.reset('password'),
})

const submitVerificationForm = () => verificationForm.transform((data) => ({
    phone: phoneForm.phone,
})).submit({
    onFinish: () => {
        verificationCodeSent.value = true
        toast.success('We have sent your verification code!', {
            description: 'Check your sms and copy the verification code.',
        })
    }
})

const back = () => emit('back')
</script>

<template>
    <form
        @submit.prevent="submitPhoneForm"
        class="grid gap-4">
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

        <div class="grid gap-2">
            <Label for="verification_code">
                {{ $t('Verification code') }}
            </Label>

            <PinInput
                v-model="phoneForm.password"
                @change="phoneForm.validate('password')"
                id="verification_code"
                :disabled="! verificationCodeSent">
                <PinInputGroup>
                    <PinInputInput
                        v-for="(id, index) in 6"
                        :key="id"
                        :index="index"
                    />
                </PinInputGroup>
            </PinInput>

            <ErrorMessage v-if="phoneForm.invalid('password')">
                {{ phoneForm.errors.password }}
            </ErrorMessage>
        </div>

        <div class="flex items-center space-x-2">
            <Checkbox v-model:checked="phoneForm.remember" id="remember" />
            <Label for="remember">
                {{ $t('Remember me') }}
            </Label>
        </div>

        <Button
            :disabled="! verificationCodeSent || phoneForm.processing"
            class="w-full">
            {{ $t('Sign in') }}
        </Button>

        <Button
            @click="submitVerificationForm"
            type="button"
            class="w-full">
            {{ $t('Message verification code') }}
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
