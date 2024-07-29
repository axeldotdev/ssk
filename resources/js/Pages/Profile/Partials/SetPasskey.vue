<script setup>
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import { Card, CardContent, CardFooter } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'
import { startRegistration } from '@simplewebauthn/browser'

const setPasskeyForm = useForm('post', route('passkeys.store'), {
    name: '',
    passkey: '',
})

const submitSetPasskeyForm = async () => {
    const options = await axios.get(route('passkeys.options'));
    const passkey = await startRegistration(options.data);

    setPasskeyForm.transform((data) => ({
        ...data,
        passkey: JSON.stringify(passkey),
    })).submit({
        preserveScroll: true,
    })
}
</script>

<template>
<div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
    <div class="grid gap-2 text-sm">
        <h2 class="text-xl font-semibold text-neutral-800">
            {{ $t('Set passkey') }}
        </h2>
        <p class="text-neutral-500">
            {{ $t('Create a new passkey for passwordless authentication.') }}
        </p>
    </div>
    <div class="grid gap-6">
        <Card>
            <CardContent class="pt-8">
                <form @submit.prevent="submitSetPasskeyForm" class="grid gap-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2 content-start">
                            <Label for="passkeyName">
                                {{ $t('Passkey name') }}
                            </Label>

                            <Input
                                v-model="setPasskeyForm.name"
                                @change="setPasskeyForm.validate('name')"
                                id="passkeyName"
                                type="text" />

                            <ErrorMessage v-if="setPasskeyForm.invalid('name')">
                                {{ setPasskeyForm.errors.name }}
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
