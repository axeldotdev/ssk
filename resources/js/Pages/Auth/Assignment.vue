<script setup>
import { Head } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

import GuestLayout from '@/Layouts/GuestLayout.vue'

import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'

defineProps({
    companies: {
        type: Array,
    },
})

const form = useForm('post', route('assignment.store'), {
    company: '',
})

const submit = (company) => {
    form.company = company
    form.submit()
}
</script>

<template>
    <Head :title="$t('Company assignment')" />

    <GuestLayout>
        <Card class="mx-auto w-128">
            <CardHeader>
                <CardTitle class="text-xl">
                    {{ $t('Company assignment') }}
                </CardTitle>
                <CardDescription>
                    {{ $t('Select one of your companies below.') }}
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div class="grid gap-2">
                    <Button
                        v-for="company in companies"
                        :key="company.uuid"
                        @click="submit(company.uuid)"
                        variant="outline"
                        type="button">
                        {{ company.name }}
                    </Button>
                </div>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
