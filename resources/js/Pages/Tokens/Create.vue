<script setup>
import { Head, Link } from '@inertiajs/vue3'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import { ChevronDown, Slash } from 'lucide-vue-next'

import {
    BreadcrumbItem,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

import Breadcrumb from '@/components/Breadcrumb.vue'
import Header from '@/components/Header.vue'

defineProps({
    tokens: {
        type: Object,
    },
})
</script>

<template>
    <Head :title="$t('API tokens')"/>

    <AuthenticatedLayout>
        <Breadcrumb>
            <BreadcrumbItem>
                <DropdownMenu>
                    <DropdownMenuTrigger class="flex items-center gap-1">
                        <BreadcrumbLink as-child>
                            <Link :href="route('tokens.index')">
                                {{ $t('API tokens') }}
                            </Link>
                        </BreadcrumbLink>
                        <ChevronDown class="h-4 w-4" />
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="start">
                        <DropdownMenuItem as-child>
                            <Link :href="route('profile.edit')">
                                {{ $t('My account') }}
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link :href="route('company.edit')">
                                {{ $t('My company') }}
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link :href="route('documentation.get-started')">
                                {{ $t('API documentation') }}
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </BreadcrumbItem>
            <BreadcrumbSeparator>
                <Slash />
            </BreadcrumbSeparator>
            <BreadcrumbItem>
                <BreadcrumbPage>
                    {{ $t('Create token') }}
                </BreadcrumbPage>
            </BreadcrumbItem>
        </Breadcrumb>

        <Header>
            {{ $t('Create token') }}
        </Header>
    </AuthenticatedLayout>
</template>
