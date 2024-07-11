<script setup>
import { usePage } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardFooter,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'

const currentCompany = usePage().props.auth.currentCompany

const companyInformationsForm = useForm('put', route('company.update'), {
    name: currentCompany.name,
})
</script>

<template>
    <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
        <div class="grid gap-2 text-sm">
            <h2 class="text-xl font-semibold text-neutral-800">
                {{ $t('Company informations') }}
            </h2>
            <p class="text-neutral-500">
                {{ $t("Update your company informations.") }}
            </p>
        </div>
        <div class="grid gap-6">
            <Card>
                <CardContent class="pt-8">
                    <form @submit.prevent="submitCompanyInformationsForm" class="grid gap-4">
                        <div class="grid gap-2 content-start">
                            <Label for="firstname">
                                {{ $t('Name') }}
                            </Label>

                            <Input
                                v-model="companyInformationsForm.name"
                                @change="companyInformationsForm.validate('name')"
                                id="name"
                                placeholder="Orvéa"
                                autocomplete="name" />

                            <ErrorMessage v-if="companyInformationsForm.invalid('name')">
                                {{ companyInformationsForm.errors.name }}
                            </ErrorMessage>
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
