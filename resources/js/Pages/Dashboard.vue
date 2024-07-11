<script setup>
import { Head } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import {
    BreadcrumbItem,
    BreadcrumbPage,
} from '@/components/ui/breadcrumb'

import Breadcrumb from '@/components/Breadcrumb.vue'
import Header from '@/components/Header.vue'
</script>

<template>
    <Head :title="$t('Dashboard')" />

    <AuthenticatedLayout>
        <Breadcrumb>
            <BreadcrumbItem>
                <BreadcrumbPage>
                    {{ $t('Dashboard') }}
                </BreadcrumbPage>
            </BreadcrumbItem>
        </Breadcrumb>

        <Header>
            {{ $t('Dashboard') }}
        </Header>
    </AuthenticatedLayout>
</template>
