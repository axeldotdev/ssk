<script setup>
import { ChevronDown } from 'lucide-vue-next'
import { Link, usePage, router } from '@inertiajs/vue3';
import breadcrumb from '@/data/breadcrumbs.json'

import Breadcrumb from '@/components/Breadcrumb.vue'

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
import { computed } from 'vue';

const currentRoute = usePage().props.ziggy.currentRoute

const currentBreadcrumb = computed(() => {
    return breadcrumb[currentRoute] ?? []
})

const filterArray = function (array) {
    let newArray = [...array]
    newArray.shift()
    return newArray
}
</script>

<template>
    <Breadcrumb v-if="currentBreadcrumb.length > 0">
        <BreadcrumbItem v-for="(item, index) in currentBreadcrumb" :key="index">
            <DropdownMenu v-if="Array.isArray(item)">
                <DropdownMenuTrigger class="flex items-center gap-1">
                    <BreadcrumbPage>
                        {{ $t(item[0].title) }}
                    </BreadcrumbPage>
                    <ChevronDown class="h-4 w-4" />
                </DropdownMenuTrigger>
                <DropdownMenuContent align="start">
                    <DropdownMenuItem as-child v-for="(subitem, subindex) in filterArray(item)" :key="subindex">
                        <Link :href="route(subitem.link)">
                        {{ $t(subitem.title) }}
                        </Link>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </BreadcrumbItem>
    </Breadcrumb>
</template>