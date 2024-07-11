<script setup>
import { ref } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

import { toast } from 'vue-sonner'

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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

import ErrorMessage from '@/components/ErrorMessage.vue'

const props = defineProps({
    company: {
        type: Object,
    },
    invitation: {
        type: Object,
    },
})

const countries = usePage().props.countries

const locales = usePage().props.locales

const verificationCodeSent = ref(false)

const form = useForm('put', route('companies.invitations.update', {
    company: props.company.id,
    invitation: props.invitation.id,
}), {
    register_method: props.invitation.email ? 'email' : 'phone',
    country: '',
    locale: '',
    firstname: '',
    lastname: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    terms: false,
})

const submit = () => form.transform((data) => ({
    ...data,
    password: data.password.join(''),
})).submit({
    onFinish: () => form.reset('password', 'password_confirmation'),
})

const submitVerificationForm = () => verificationForm.submit({
    onFinish: () => {
        verificationCodeSent.value = true
        toast.success('We have sent your verification code!', {
            description: 'Check your sms and copy the verification code.',
        })
    }
})
</script>

<template>
    <Head :title="$t('Accept invitation')" />

    <GuestLayout>
        <Card class="mx-auto w-128">
            <CardHeader>
                <CardTitle class="text-xl">
                    {{ $t('Accept invitation') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('Join the company') }} {{ company.name }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="grid gap-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="country">
                                {{ $t('Country') }}
                            </Label>

                            <Select
                                id="country"
                                v-model="form.country"
                                @change="form.validate('country')">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a country" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="(country, index) in countries"
                                        :key="index"
                                        :value="index">
                                        {{ country }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>

                            <ErrorMessage v-if="form.invalid('country')">
                                {{ form.errors.country }}
                            </ErrorMessage>
                        </div>

                        <div class="grid gap-2">
                            <Label for="locale">
                                {{ $t('Locale') }}
                            </Label>

                            <Select
                                id="locale"
                                v-model="form.locale"
                                @change="form.validate('locale')">
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a locale" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="(locale, index) in locales"
                                        :key="index"
                                        :value="index">
                                        {{ locale }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>

                            <ErrorMessage v-if="form.invalid('locale')">
                                {{ form.errors.locale }}
                            </ErrorMessage>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="firstname">
                                {{ $t('Firstname') }}
                            </Label>

                            <Input
                                v-model="form.firstname"
                                @change="form.validate('firstname')"
                                id="firstname"
                                placeholder="John"
                                autocomplete="firstname" />

                            <ErrorMessage v-if="form.invalid('firstname')">
                                {{ form.errors.firstname }}
                            </ErrorMessage>
                        </div>

                        <div class="grid gap-2">
                            <Label for="lastname">
                                {{ $t('Lastname') }}
                            </Label>

                            <Input
                                v-model="form.lastname"
                                @change="form.validate('lastname')"
                                id="lastname"
                                placeholder="Doe"
                                autocomplete="lastname" />

                            <ErrorMessage v-if="form.invalid('lastname')">
                                {{ form.errors.lastname }}
                            </ErrorMessage>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="email">
                                {{ $t('Email') }}
                            </Label>

                            <Input
                                v-model="form.email"
                                @change="form.validate('email')"
                                id="email"
                                type="email"
                                placeholder="support@orvea.io"
                                autocomplete="username" />

                            <ErrorMessage v-if="form.invalid('email')">
                                {{ form.errors.email }}
                            </ErrorMessage>
                        </div>

                        <div class="grid gap-2">
                            <Label for="phone">
                                {{ $t('Phone') }}
                            </Label>

                            <Input
                                v-model="form.phone"
                                @change="form.validate('phone')"
                                id="phone"
                                type="tel"
                                autocomplete="username" />

                            <ErrorMessage v-if="form.invalid('phone')">
                                {{ form.errors.phone }}
                            </ErrorMessage>
                        </div>
                    </div>

                    <div v-if="invitation.email" class="grid grid-cols-2 gap-4">
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

                    <div v-if="invitation.phone" class="grid gap-2">
                        <Label for="verification_code">
                            {{ $t('Verification code') }}
                        </Label>

                        <PinInput
                            v-model="form.password"
                            @change="form.validate('password')"
                            id="verification_code"
                            :disabled="! verificationCodeSent"
                        >
                            <PinInputGroup>
                                <PinInputInput
                                    v-for="(id, index) in 6"
                                    :key="id"
                                    :index="index"
                                />
                            </PinInputGroup>
                        </PinInput>

                        <ErrorMessage v-if="form.invalid('password')">
                            {{ form.errors.password }}
                        </ErrorMessage>
                    </div>

                    <div class="flex items-center space-x-2">
                        <Checkbox v-model:checked="form.terms" id="terms" />
                        <Label for="terms">
                            {{ $t('I accept the terms and conditions') }}
                        </Label>
                    </div>

                    <Button :disabled="(invitation.phone && ! verificationCodeSent) || form.processing">
                        {{ $t('Register your account') }}
                    </Button>

                    <Button @click="submitVerificationForm" type="button" class="w-full">
                        {{ $t('Email verification code') }}
                    </Button>
                </form>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
