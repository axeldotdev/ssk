<script setup>
import { Head, Link } from '@inertiajs/vue3'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import { ChevronDown } from 'lucide-vue-next'

import {
    BreadcrumbItem,
    BreadcrumbPage,
} from '@/components/ui/breadcrumb'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

import Breadcrumb from '@/components/Breadcrumb.vue'
import CompanyInformations from '@/Pages/Company/Partials/CompanyInformations.vue'
import DeleteCompany from '@/Pages/Company/Partials/DeleteCompany.vue'
import Header from '@/components/Header.vue'
import Members from '@/Pages/Company/Partials/Members.vue'
import TransferCompany from '@/Pages/Company/Partials/TransferCompany.vue'

defineProps({
    members: {
        type: Array,
    },
})
</script>

<template>
    <Head :title="$t('My company')"/>

    <AuthenticatedLayout>
        <Breadcrumb>
            <BreadcrumbItem>
                <DropdownMenu>
                    <DropdownMenuTrigger class="flex items-center gap-1">
                        <BreadcrumbPage>
                            {{ $t('My company') }}
                        </BreadcrumbPage>
                        <ChevronDown class="h-4 w-4" />
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="start">
                        <DropdownMenuItem as-child>
                            <Link :href="route('profile.edit')">
                                {{ $t('My account') }}
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link :href="route('tokens.index')">
                                {{ $t('API tokens') }}
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link :href="route('documentation', { firstLevel: 'get-started'})">
                                {{ $t('API documentation') }}
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </BreadcrumbItem>
        </Breadcrumb>

        <Header>
            {{ $t('My company') }}
        </Header>

        <CompanyInformations></CompanyInformations>

        <Members :members="members"></Members>

        <TransferCompany :members="members"></TransferCompany>

        <DeleteCompany></DeleteCompany>
    </AuthenticatedLayout>
</template>
