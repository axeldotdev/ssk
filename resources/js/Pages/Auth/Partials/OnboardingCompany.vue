<script setup>
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

import ErrorMessage from '@/components/ErrorMessage.vue'

const emit = defineEmits(['submit'])

const companyForm = useForm('post', route('onboarding.company'), {
    name: '',
})

const submitCompanyForm = () => companyForm.submit({
    onFinish: () => emit('submit'),
})
</script>

<template>
    <Card class="mx-auto w-128">
        <CardHeader>
            <CardTitle class="text-xl">
                {{ $t('Create your company') }}
            </CardTitle>
            <CardDescription>
                {{ $t('Add you company logo and name.') }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submitCompanyForm" class="grid gap-4">
                <div class="grid gap-2">
                    <Label for="name">
                        {{ $t('Name') }}
                    </Label>

                    <Input
                        v-model="companyForm.name"
                        @change="companyForm.validate('name')"
                        id="name"
                        placeholder="Laravel" />

                    <ErrorMessage v-if="companyForm.invalid('name')">
                        {{ companyForm.errors.name }}
                    </ErrorMessage>
                </div>

                <Button :disabled="companyForm.processing" type="submit">
                    {{ $t('Create company') }}
                </Button>
            </form>
        </CardContent>
    </Card>
</template>
