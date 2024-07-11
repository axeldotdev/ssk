<script setup>
import { Head, Link } from '@inertiajs/vue3'
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

import ErrorMessage from '@/components/ErrorMessage.vue'

const props = defineProps({
    status: {
        type: String,
    },
})

const form = useForm('post', route('password.email'), {
    email: '',
})

const submit = () => form.submit({
    onFinish: () => toast.success(props.status, {
        description: 'Check your inbox and spams folder.',
    }),
})
</script>

<template>
    <Head :title="$t('Forgot your password')" />

    <GuestLayout>
        <Card class="mx-auto w-128">
            <CardHeader>
                <CardTitle class="text-xl">
                    {{ $t('Forgot your password?') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">
                            {{ $t('Email') }}
                        </Label>

                        <Input
                            id="email"
                            type="email"
                            v-model="form.email"
                            @change="form.validate('email')"
                            autocomplete="username" />

                        <ErrorMessage v-if="form.invalid('email')">
                            {{ form.errors.email }}
                        </ErrorMessage>
                    </div>

                    <Button :disabled="form.processing">
                        {{ $t('Email password reset link') }}
                    </Button>

                    <Button type="button" variant="outline" as-child>
                        <Link :href="route('login')">
                            {{ $t('Back to login') }}
                        </Link>
                    </Button>
                </form>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
