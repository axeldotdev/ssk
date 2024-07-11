<script setup>
import { computed, onMounted } from 'vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
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
import { Label } from '@/components/ui/label'
import {
    PinInput,
    PinInputGroup,
    PinInputInput,
} from '@/components/ui/pin-input'

const props = defineProps({
    status: {
        type: String,
    },
})

const signMethod = usePage().props.signMethod

const user = usePage().props.auth.user

const verificationLinkSent = computed(() => props.status === 'verification-link-sent')

onMounted(() => {
    if (verificationLinkSent) {
        toast.success('A new verification link has been sent!', {
            description: 'Check your inbox and spams folder.',
        })
    }
})

const emailVerificationform = useForm('post', route('verification.send'), {})

const phoneVerificationForm = useForm('post', route('phone-verification.send'), {
    phone: user.phone,
})

const phoneForm = useForm('post', route('phone-verification.verify'), {
    password: [],
})

const submitEmailVerificationForm = () => emailVerificationform.submit({
    onFinish: () => toast.success('A new verification link has been sent!', {
        description: 'Check your inbox and spams folder.',
    })
})

const submitPhoneVerificationForm = () => phoneVerificationForm.submit({
    onFinish: () => {
        toast.success('We have sent your verification code!', {
            description: 'Check your sms and copy the verification code.',
        })
    }
})

const submitPhoneForm = () => phoneForm.transform((data) => ({
    password: data.password.join(''),
})).submit({
    onFinish: () => phoneForm.reset('password'),
})
</script>

<template>
    <Head :title="$t('Verify your account')" />

    <GuestLayout>
        <Card class="mx-auto w-128">
            <CardHeader>
                <CardTitle class="text-xl">
                    {{ $t('Verify your account') }}
                </CardTitle>
                <CardDescription>
                    <template v-if="signMethod === 'email'">
                        {{ $t("Thanks for signing up! Before getting started, could you verify your account by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
                    </template>
                    <template v-if="signMethod === 'phone'">
                        {{ $t("Thanks for signing up! Before getting started, could you verify your account by entering the code we just sent to you? If you didn't receive the sms, we will gladly send you another.") }}
                    </template>
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div class="grid gap-4">
                    <form
                        v-if="signMethod === 'email'"
                        @submit.prevent="submitEmailVerificationForm"
                        class="grid">
                        <Button :disabled="submitEmailVerificationForm.processing">
                            {{ $t('Resend verification email') }}
                        </Button>
                    </form>

                    <form
                        v-if="signMethod === 'phone'"
                        @submit.prevent="submitPhoneForm"
                        class="grid gap-4">
                        <div class="grid gap-2">
                            <Label for="verification_code">
                                {{ $t('Verification code') }}
                            </Label>

                            <PinInput
                                v-model="phoneForm.password"
                                id="verification_code">
                                <PinInputGroup>
                                    <PinInputInput
                                        v-for="(id, index) in 6"
                                        :key="id"
                                        :index="index" />
                                </PinInputGroup>
                            </PinInput>
                        </div>

                        <Button :disabled="phoneForm.processing" class="w-full">
                            {{ $t('Verify account') }}
                        </Button>

                        <Button
                            @click="submitPhoneVerificationForm"
                            type="button"
                            class="w-full">
                            {{ $t('Resend verification code') }}
                        </Button>
                    </form>

                    <Button variant="outline" as-child class="w-full">
                        <Link :href="route('logout')" method="post" as="button">
                            {{ $t('Sign out') }}
                        </Link>
                    </Button>
                </div>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
