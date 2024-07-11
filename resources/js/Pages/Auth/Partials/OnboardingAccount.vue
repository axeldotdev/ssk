<script setup>
import { usePage } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

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

const user = usePage().props.auth.user

const countries = usePage().props.countries

const locales = usePage().props.locales

const accountForm = useForm('post', route('onboarding.account'), {
    country: user.country,
    locale: user.locale,
    firstname: user.firstname,
    lastname: user.lastname,
})

const submitAccountForm = () => accountForm.submit({
    onFinish: () => {
        currentTab.value = 'company'
        activeTab.value = 'company'
    },
})
</script>

<template>
    <Card class="mx-auto w-128">
        <CardHeader>
            <CardTitle class="text-xl">
                {{ $t('Complete your account') }}
            </CardTitle>
            <CardDescription>
                {{ $t('Start by completing your account.') }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submitAccountForm" class="grid gap-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="country">
                            {{ $t('Country') }}
                        </Label>

                        <Select
                            id="country"
                            v-model="accountForm.country"
                            @change="accountForm.validate('country')">
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

                        <ErrorMessage v-if="accountForm.invalid('country')">
                            {{ accountForm.errors.country }}
                        </ErrorMessage>
                    </div>

                    <div class="grid gap-2">
                        <Label for="locale">
                            {{ $t('Locale') }}
                        </Label>

                        <Select
                            id="locale"
                            v-model="accountForm.locale"
                            @change="accountForm.validate('locale')">
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

                        <ErrorMessage v-if="accountForm.invalid('locale')">
                            {{ accountForm.errors.locale }}
                        </ErrorMessage>
                    </div>
                </div>

                <div v-if="signUpMethod === 'sso'" class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="firstname">
                            {{ $t('Firstname') }}
                        </Label>

                        <Input
                            v-model="accountForm.firstname"
                            @change="accountForm.validate('firstname')"
                            id="firstname"
                            placeholder="John"
                            autocomplete="firstname" />

                        <ErrorMessage v-if="accountForm.invalid('firstname')">
                            {{ accountForm.errors.firstname }}
                        </ErrorMessage>
                    </div>

                    <div class="grid gap-2">
                        <Label for="lastname">
                            {{ $t('Lastname') }}
                        </Label>

                        <Input
                            v-model="accountForm.lastname"
                            @change="accountForm.validate('lastname')"
                            id="lastname"
                            placeholder="Doe"
                            autocomplete="lastname" />

                        <ErrorMessage v-if="accountForm.invalid('lastname')">
                            {{ accountForm.errors.lastname }}
                        </ErrorMessage>
                    </div>
                </div>

                <Button :disabled="accountForm.processing" type="submit">
                    {{ $t('Complete account') }}
                </Button>
            </form>
        </CardContent>
    </Card>
</template>
