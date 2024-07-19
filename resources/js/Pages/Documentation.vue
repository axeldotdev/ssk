<script setup>
import { Head, Link } from '@inertiajs/vue3'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import { ChevronDown, Slash } from 'lucide-vue-next'

import {
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb'
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

import Breadcrumb from '@/components/Breadcrumb.vue'
import Header from '@/components/Header.vue'

defineProps({
    title: String,
    content: String,
})
</script>

<template>
    <Head :title="`${$t('API documentation')} - ${title}`"/>

    <AuthenticatedLayout>
        <Breadcrumb>
            <BreadcrumbItem>
                <DropdownMenu>
                    <DropdownMenuTrigger class="flex items-center gap-1">
                        <BreadcrumbLink as-child>
                            {{ $t('API documentation') }}
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
                            <Link :href="route('tokens.index')">
                                {{ $t('API tokens') }}
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
                    {{ title }}
                </BreadcrumbPage>
            </BreadcrumbItem>
        </Breadcrumb>

        <Header>
            {{ title }}

            <template v-slot:actions>
                <Button as-child>
                    <Link :href="route('tokens.create')">
                        {{ $t('Create token') }}
                    </Link>
                </Button>
            </template>
        </Header>

        <div v-html="content" class="w-full prose prose-neutral" />
    </AuthenticatedLayout>
</template>
