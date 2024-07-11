<script setup>
import { usePage } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import { Card, CardContent, CardFooter } from '@/components/ui/card'
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

const user = usePage().props.auth.user

const countries = usePage().props.countries

const locales = usePage().props.locales

const personalInformationsForm = useForm('put', route('register'), {
    firstname: user.firstname,
    lastname: user.lastname,
    email: user.email,
    phone: user.phone,
    country: user.country,
    locale: user.locale,
})

const submitPersonalInformationsForm = () => personalInformationsForm.submit({
    preserveScroll: true,
})
</script>

<template>
    <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
        <div class="grid gap-2 text-sm">
            <h2 class="text-xl font-semibold text-neutral-800">
                {{ $t('Personal informations') }}
            </h2>
            <p class="text-neutral-500">
                {{ $t("Update your account's profile information and email address.") }}
            </p>
        </div>
        <div class="grid gap-6">
            <Card>
                <CardContent class="pt-8">
                    <form @submit.prevent="submitPersonalInformationsForm" class="grid gap-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="grid gap-2 content-start">
                                <Label for="firstname">
                                    {{ $t('Firstname') }}
                                </Label>

                                <Input
                                    v-model="personalInformationsForm.firstname"
                                    @change="personalInformationsForm.validate('firstname')"
                                    id="firstname"
                                    placeholder="John"
                                    autocomplete="firstname" />

                                <ErrorMessage v-if="personalInformationsForm.invalid('firstname')">
                                    {{ personalInformationsForm.errors.firstname }}
                                </ErrorMessage>
                            </div>

                            <div class="grid gap-2 content-start">
                                <Label for="lastname">
                                    {{ $t('Lastname') }}
                                </Label>

                                <Input
                                    v-model="personalInformationsForm.lastname"
                                    @change="personalInformationsForm.validate('lastname')"
                                    id="lastname"
                                    placeholder="Doe"
                                    autocomplete="lastname" />

                                <ErrorMessage v-if="personalInformationsForm.invalid('lastname')">
                                    {{ personalInformationsForm.errors.lastname }}
                                </ErrorMessage>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="grid gap-2">
                                <Label for="email">
                                    {{ $t('Email') }}
                                </Label>

                                <Input
                                    v-model="personalInformationsForm.email"
                                    @change="personalInformationsForm.validate('email')"
                                    id="email"
                                    type="email"
                                    placeholder="support@orvea.io"
                                    autocomplete="username" />

                                <ErrorMessage v-if="personalInformationsForm.invalid('email')">
                                    {{ personalInformationsForm.errors.email }}
                                </ErrorMessage>
                            </div>
                            <div class="grid gap-2">
                                <Label for="phone">
                                    {{ $t('Phone') }}
                                </Label>

                                <Input
                                    v-model="personalInformationsForm.phone"
                                    @change="personalInformationsForm.validate('phone')"
                                    id="phone"
                                    type="tel"
                                    placeholder=""
                                    autocomplete="username" />

                                <ErrorMessage v-if="personalInformationsForm.invalid('phone')">
                                    {{ personalInformationsForm.errors.phone }}
                                </ErrorMessage>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="grid gap-2">
                                <Label for="country">
                                    {{ $t('Country') }}
                                </Label>

                                <Select
                                    id="country"
                                    v-model="personalInformationsForm.country"
                                    @change="personalInformationsForm.validate('country')">
                                    <SelectTrigger>
                                        <SelectValue :placeholder="$t('Select a country')" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="(country, index) in countries" :key="index" :value="index">
                                            {{ country }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>

                                <ErrorMessage v-if="personalInformationsForm.invalid('country')">
                                    {{ personalInformationsForm.errors.country }}
                                </ErrorMessage>
                            </div>

                            <div class="grid gap-2">
                                <Label for="locale">
                                    {{ $t('Locale') }}
                                </Label>

                                <Select
                                    id="locale"
                                    v-model="personalInformationsForm.locale"
                                    @change="personalInformationsForm.validate('locale')">
                                    <SelectTrigger>
                                        <SelectValue :placeholder="$t('Select a locale')" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="(locale, index) in locales" :key="index" :value="index">
                                            {{ locale }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>

                                <ErrorMessage v-if="personalInformationsForm.invalid('locale')">
                                    {{ personalInformationsForm.errors.locale }}
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
