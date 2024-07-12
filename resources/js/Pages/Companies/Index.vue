<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { useForm } from 'laravel-precognition-vue-inertia'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import {
    ChevronsLeft,
    ChevronsRight,
    ChevronLeft,
    ChevronRight,
    Search,
} from 'lucide-vue-next'

import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import {
    BreadcrumbItem,
    BreadcrumbPage,
} from '@/components/ui/breadcrumb'
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

const props = defineProps({
    filters: {
        type: Object,
    },
    companies: {
        type: Object,
    },
})

const urlParams = computed(() => {
    let params = new URLSearchParams()

    if (searchForm.name !== '') {
        params.append('name', searchForm.name)
    }

    return params.toString()
})

const searchForm = useForm('get', route('companies.index'), {
    name: props.filters?.name ?? '',
})

const submitSearchForm = () => {
    searchForm.submit({
        preserveScroll: true,
        preserveState: true,
    })
}
</script>

<template>
    <Head :title="$t('Companies')" />

    <AuthenticatedLayout>
        <Breadcrumb>
            <BreadcrumbItem>
                <BreadcrumbPage>
                    {{ $t('Companies') }}
                </BreadcrumbPage>
            </BreadcrumbItem>
        </Breadcrumb>

        <Header>
            {{ $t('Companies') }}

            <template v-slot:actions>
                <Button as-child>
                    <Link :href="route('companies.create')">
                        {{ $t('Create company') }}
                    </Link>
                </Button>
            </template>
        </Header>

        <div v-if="companies.data.length" class="mx-auto grid w-full max-w-6xl gap-2">
            <div class="flex justify-between items-center gap-4 mb-4">
                <div class="relative w-full max-w-sm items-center">
                    <Input
                        @input.bounce="submitSearchForm"
                        v-model="searchForm.name"
                        placeholder="Search companies..."
                        class="pl-10" />
                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                        <Search class="size-5 text-neutral-500" />
                    </span>
                </div>
            </div>

            <template v-for="company in companies.data" :key="company.uuid">
                <Card v-if="company.can.view">
                    <CardContent class="grid grid-cols-3 gap-4 p-4">
                        <Link
                            :href="route('companies.show', company)"
                            class="text-lg font-semibold text-neutral-800">
                            {{ company.name }}
                        </Link>
                        <div v-if="company.user">
                            <div class="font-medium text-neutral-800">
                                {{ company.user.fullname }}
                            </div>
                            <div class="font-medium text-sm text-neutral-500">
                                {{ company.user.email }}
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </template>

            <Pagination
                v-slot="{ page }"
                :total="companies.total"
                :sibling-count="1"
                show-edges
                :default-page="companies.current_page"
                :items-per-page="25"
                class="mt-8">
                <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                    <PaginationFirst as-child>
                        <Link :href="`${companies.first_page_url}&${urlParams}`">
                            <ChevronsLeft class="h-4 w-4" />
                        </Link>
                    </PaginationFirst>

                    <PaginationPrev as-child>
                        <Link :href="companies.prev_page_url !== null ? `${companies.prev_page_url}&${urlParams}` : ''">
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
                                <Link :href="`${companies.path}?page=${item.value}&${urlParams}`">
                                    {{ item.value }}
                                </Link>
                            </Button>
                        </PaginationListItem>
                        <PaginationEllipsis v-else :key="item.type" :index="index" />
                    </template>

                    <PaginationNext as-child>
                        <Link :href="companies.next_page_url !== null ? `${companies.next_page_url}&${urlParams}` : ''">
                            <ChevronRight class="h-4 w-4" />
                        </Link>
                    </PaginationNext>

                    <PaginationLast as-child>
                        <Link :href="`${companies.last_page_url}&${urlParams}`">
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
                        {{ $t('Create a company and invite your collaborators.') }}
                    </h2>
                    <Button as-child>
                        <Link :href="route('tokens.create')">
                            {{ $t('Create company') }}
                        </Link>
                    </Button>
                </CardContent>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
