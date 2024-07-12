<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import {
    ChevronsLeft,
    ChevronsRight,
    ChevronLeft,
    ChevronRight,
    ChevronDown,
} from 'lucide-vue-next'

import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog'
import {
    BreadcrumbItem,
    BreadcrumbPage,
} from '@/components/ui/breadcrumb'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/components/ui/pagination'

import Breadcrumb from '@/components/Breadcrumb.vue'
import Header from '@/components/Header.vue'

defineProps({
    tokens: {
        type: Object,
    },
})

const submitRevokeTokenForm = (token) => {
    router.delete(route('tokens.destroy', token))
}
</script>

<template>
    <Head :title="$t('API tokens')"/>

    <AuthenticatedLayout>
        <Breadcrumb>
            <BreadcrumbItem>
                <DropdownMenu>
                    <DropdownMenuTrigger class="flex items-center gap-1">
                        <BreadcrumbPage>
                            {{ $t('API tokens') }}
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
        </Breadcrumb>

        <Header>
            {{ $t('API tokens') }}

            <template v-slot:actions>
                <Button variant="link" as-child>
                    <Link :href="route('documentation.get-started')">
                        {{ $t('API documentation') }}
                    </Link>
                </Button>
                <Button as-child>
                    <Link :href="route('tokens.create')">
                        {{ $t('Create token') }}
                    </Link>
                </Button>
            </template>
        </Header>

        <div v-if="tokens.data.length" class="mx-auto grid w-full max-w-6xl gap-2">
            <template v-for="token in tokens.data" :key="token.id">
                <Card>
                    <CardContent class="grid grid-cols-4 gap-4 p-4">
                        <h2 class="text-lg font-semibold text-neutral-800">
                            {{ token.name }}
                        </h2>
                        <div>
                            <div class="font-medium text-sm text-neutral-500">
                                {{ $t('Last used at') }}
                            </div>
                            <div class="font-medium text-neutral-800">
                                {{ token.last_used_at ? token.last_used_at : $t('Never')}}
                            </div>
                        </div>
                        <div>
                            <div class="font-medium text-sm text-neutral-500">
                                {{ $t('Expires at') }}
                            </div>
                            <div class="font-medium text-neutral-800">
                                {{ token.expires_at ? token.expires_at : $t('Never') }}
                            </div>
                        </div>
                        <div class="flex justify-end items-center">
                            <AlertDialog>
                                <AlertDialogTrigger as-child>
                                    <Button type="button" variant="destructive">
                                        {{ $t('Revoke') }}
                                    </Button>
                                </AlertDialogTrigger>
                                <AlertDialogContent>
                                    <AlertDialogHeader>
                                        <AlertDialogTitle>
                                            {{ $t('Are you absolutely sure?') }}
                                        </AlertDialogTitle>
                                        <AlertDialogDescription>
                                            {{ $t('This action cannot be undone. This will permanently delete your token.') }}
                                        </AlertDialogDescription>
                                    </AlertDialogHeader>
                                    <AlertDialogFooter>
                                        <AlertDialogCancel>
                                            {{ $t('Cancel') }}
                                        </AlertDialogCancel>
                                        <AlertDialogAction @click="submitRevokeTokenForm(token.id)" class="bg-red-500 hover:bg-red-500/90">
                                            {{ $t('Revoke') }}
                                        </AlertDialogAction>
                                    </AlertDialogFooter>
                                </AlertDialogContent>
                            </AlertDialog>
                        </div>
                    </CardContent>
                </Card>
            </template>

            <Pagination
                v-slot="{ page }"
                :total="tokens.total"
                :sibling-count="1"
                show-edges
                :default-page="tokens.current_page"
                :items-per-page="25"
                class="mt-8">
                <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                    <PaginationFirst as-child>
                        <Link :href="`${tokens.first_page_url}`">
                            <ChevronsLeft class="h-4 w-4" />
                        </Link>
                    </PaginationFirst>

                    <PaginationPrev as-child>
                        <Link :href="tokens.prev_page_url !== null ? `${tokens.prev_page_url}` : ''">
                            <ChevronLeft class="h-4 w-4" />
                        </Link>
                    </PaginationPrev>

                    <template v-for="(item, index) in items">
                        <PaginationListItem
                            v-if="item.type === 'page'"
                            :key="index"
                            :value="item.value"
                            as-child>
                            <Button
                                :variant="item.value === page ? 'default' : 'outline'"
                                class="w-10 h-10 p-0"
                                as-child>
                                <Link :href="`${tokens.path}?page=${item.value}`">
                                    {{ item.value }}
                                </Link>
                            </Button>
                        </PaginationListItem>
                        <PaginationEllipsis v-else :key="item.type" :index="index" />
                    </template>

                    <PaginationNext as-child>
                        <Link :href="tokens.next_page_url !== null ? `${tokens.next_page_url}` : ''">
                            <ChevronRight class="h-4 w-4" />
                        </Link>
                    </PaginationNext>

                    <PaginationLast as-child>
                        <Link :href="`${tokens.last_page_url}`">
                            <ChevronsRight class="h-4 w-4" />
                        </Link>
                    </PaginationLast>
                </PaginationList>
            </Pagination>
        </div>

        <div v-else class="mx-auto grid w-full max-w-6xl gap-2">
            <Card>
                <CardContent class="flex flex-col justify-center items-center min-h-64 pt-6">
                    <h2 class="mb-6 text-lg font-semibold text-neutral-800">
                        {{ $t('You need to use the API? Create a token here.') }}
                    </h2>
                    <Button as-child>
                        <Link :href="route('tokens.create')">
                            {{ $t('Create token') }}
                        </Link>
                    </Button>
                </CardContent>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
