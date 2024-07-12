<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';

import ApplicationLogo from '@/components/ApplicationLogo.vue';
import {
    Search,
    LayoutDashboard,
    Building2,
    CircleCheck,
} from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

import NavLink from '@/components/NavLink.vue'

const appName = usePage().props.appName
const can = usePage().props.auth.can
const companies = usePage().props.auth.companies
const user = usePage().props.auth.user
const currentCompany = usePage().props.auth.currentCompany
const currentRoute = usePage().props.ziggy.currentRoute

const switchCompany = (uuid) => {
    router.put(route('assignment.update'), {
        company: uuid,
    }, {
        preserveScroll: true,
        preserveState: false,
    })
}

const initials = (name) => name.split(' ').map(word => word[0]).join('')

const isCurrentRoute = (route) => currentRoute === route
</script>

<template>
    <div class="flex w-full h-screen bg-neutral-50">
        <div class="shrink-0 w-64 h-full flex flex-col gap-4 bg-white p-2 text-neutral-700 border-r border-neutral-200">
            <div class="flex justify-between items-center p-2">
                <Link :href="route('dashboard')">
                    <span class="sr-only">
                        {{ appName }}
                    </span>
                    <ApplicationLogo class="h-8 w-auto fill-current text-neutral-800" />
                </Link>

                <DropdownMenu>
                    <DropdownMenuTrigger>
                        <Button variant="ghost" size="icon" class="flex justify-center items-center size-10 bg-neutral-700 text-neutral-100 rounded-full hover:bg-neutral-800 hover:text-neutral-50 transition">
                            <span class="sr-only">
                                {{ $t('Open the menu') }}
                            </span>
                            <span>
                                {{ initials(user.fullname) }}
                            </span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="start" class="min-w-48">
                        <template v-if="companies.length > 1">
                            <DropdownMenuLabel>
                                {{ $t('Switch company') }}
                            </DropdownMenuLabel>
                            <template v-for="company in companies" :key="company.uuid">
                                <DropdownMenuItem as-child class="w-full">
                                    <form @submit.prevent="switchCompany(company.uuid)">
                                        <button class="flex items-center w-full">
                                            {{ company.name }}
                                            <CircleCheck v-if="company.uuid === currentCompany.uuid" class="w-4 h-4 ml-2" />
                                        </button>
                                    </form>
                                </DropdownMenuItem>
                            </template>
                        </template>
                        <DropdownMenuSeparator v-if="companies.length > 1" />
                        <DropdownMenuItem as-child>
                            <Link :href="route('profile.edit')" :class="[isCurrentRoute('profile.edit') ? 'bg-neutral-100' : '', 'w-full cursor-pointer']">
                                {{ $t('My account') }}
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link :href="route('company.edit')" :class="[isCurrentRoute('company.edit') ? 'bg-neutral-100' : '', 'w-full cursor-pointer']">
                                {{ $t('My company') }}
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link :href="route('tokens.index')" :class="[isCurrentRoute('tokens.index') ? 'bg-neutral-100' : '', 'w-full cursor-pointer']">
                                {{ $t('API tokens') }}
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                            <Link :href="route('documentation.get-started')" :class="[isCurrentRoute('documentation.get-started') ? 'bg-neutral-100' : '', 'w-full cursor-pointer']">
                                {{ $t('API documentation') }}
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem as-child>
                            <Link :href="route('logout')" method="post" as="button" class="w-full text-red-500 cursor-pointer">
                                {{ $t('Sign out') }}
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>

            <div class="">
                <Button variant="secondary" class="w-full justify-start">
                    <Search class="w-5 h-5 mr-2 text-neutral-600" />
                    <span class="grow text-left text-neutral-600">
                        {{ $t('Search everything') }}
                    </span>
                    <kbd class="inline-flex h-5 select-none items-center gap-0.5 rounded border bg-neutral-200 px-1.5 font-mono text-[10px] font-medium text-neutral-600">
                        <span class="text-sm">⌘</span>K
                    </kbd>
                </Button>
            </div>

            <nav class="grow flex flex-col gap-1">
                <NavLink :href="route('dashboard')" :isActive="isCurrentRoute('dashboard')">
                    <LayoutDashboard class="w-5 h-5 mr-2" />
                    {{ $t('Dashboard') }}
                </NavLink>
                <NavLink v-if="can.viewAny.companies" :href="route('companies.index')" :isActive="isCurrentRoute('companies.index')">
                    <Building2 class="w-5 h-5 mr-2" />
                    {{ $t('Companies') }}
                </NavLink>
            </nav>
        </div>

        <main class="w-full h-full overflow-y-auto overflow-x-hidden">
            <div class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-10">
                <slot />
            </div>
        </main>
    </div>
</template>
