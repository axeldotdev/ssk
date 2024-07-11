<script setup>
import { Head, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import { Slash } from 'lucide-vue-next'

import { BreadcrumbItem, BreadcrumbLink, BreadcrumbPage, BreadcrumbSeparator } from '@/components/ui/breadcrumb'

import Breadcrumb from '@/components/Breadcrumb.vue'
import Header from '@/components/Header.vue'
</script>

<template>
    <Head :title="$t('Companies') + ' - ' + $t('Create')" />

    <AuthenticatedLayout>
        <Breadcrumb>
            <BreadcrumbItem>
                <BreadcrumbLink as-child>
                    <Link :href="route('companies.index')">
                        {{ $t('Companies') }}
                    </Link>
                </BreadcrumbLink>
            </BreadcrumbItem>
            <BreadcrumbSeparator>
                <Slash />
            </BreadcrumbSeparator>
            <BreadcrumbItem>
                <BreadcrumbPage>
                    {{ $t('Create company') }}
                </BreadcrumbPage>
            </BreadcrumbItem>
        </Breadcrumb>

        <Header>
            {{ $t('Create company') }}
        </Header>
    </AuthenticatedLayout>
</template>
