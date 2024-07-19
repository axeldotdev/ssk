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
import ConnectedAccounts from '@/Pages/Profile/Partials/ConnectedAccounts.vue'
import DeleteAccount from '@/Pages/Profile/Partials/DeleteAccount.vue'
import Header from '@/components/Header.vue'
import PersonalInformations from '@/Pages/Profile/Partials/PersonalInformations.vue'
import Sessions from '@/Pages/Profile/Partials/Sessions.vue'
import SetPassword from '@/Pages/Profile/Partials/SetPassword.vue'
import TwoFactorAuthentication from '@/Pages/Profile/Partials/TwoFactorAuthentication.vue'
import UpdatePassword from '@/Pages/Profile/Partials/UpdatePassword.vue'

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    socialstream: {
        type: Object,
    },
})
</script>

<template>
    <Head :title="$t('My account')"/>

    <AuthenticatedLayout>
        <Breadcrumb>
            <BreadcrumbItem>
                <DropdownMenu>
                    <DropdownMenuTrigger class="flex items-center gap-1">
                        <BreadcrumbPage>
                            {{ $t('My account') }}
                        </BreadcrumbPage>
                        <ChevronDown class="h-4 w-4" />
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="start">
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
            {{ $t('My account') }}
        </Header>

        <PersonalInformations></PersonalInformations>

        <UpdatePassword v-if="socialstream.hasPassword"></UpdatePassword>

        <SetPassword v-else></SetPassword>

        <ConnectedAccounts :socialstream="socialstream"></ConnectedAccounts>

        <Sessions></Sessions>

        <TwoFactorAuthentication></TwoFactorAuthentication>

        <DeleteAccount></DeleteAccount>
    </AuthenticatedLayout>
</template>
