<script setup>
import { usePage } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardFooter,
} from '@/components/ui/card'
import { Label } from '@/components/ui/label'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

import ErrorMessage from '@/components/ErrorMessage.vue'

defineProps({
    members: {
        type: Array,
    },
})

const user = usePage().props.auth.user

const transferForm = useForm('put', route('company.update'), {
    user: user.uuid,
})
</script>

<template>
    <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
        <div class="grid gap-2 text-sm">
            <h2 class="text-xl font-semibold text-neutral-800">
                {{ $t('Transfer company') }}
            </h2>
            <p class="text-neutral-500">
                {{ $t('Transfer your company to another member.') }}
            </p>
        </div>
        <div class="grid gap-6">
            <Card>
                <CardContent class="pt-8">
                    <form>
                        <Label for="user">
                            {{ $t('Owner') }}
                        </Label>

                        <Select
                            id="user"
                            name="user"
                            v-model="transferForm.user"
                            @change="transferForm.validate('user')"
                            required>
                            <SelectTrigger>
                                <SelectValue :placeholder="$t('Select a user')" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem v-for="user in members" :key="user.uuid" :value="user.uuid">
                                    {{ user.fullname }}
                                </SelectItem>
                            </SelectContent>
                        </Select>

                        <ErrorMessage v-if="transferForm.invalid('user')">
                            {{ transferForm.errors.user }}
                        </ErrorMessage>
                    </form>
                </CardContent>
                <CardFooter class="border-t px-6 py-4">
                    <Button variant="destructive">
                        {{ $t('Transfer company') }}
                    </Button>
                </CardFooter>
            </Card>
        </div>
    </div>
</template>
