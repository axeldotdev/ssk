<script setup>
import { usePage } from '@inertiajs/vue3'

import { Slash } from 'lucide-vue-next'

import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbList,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb'

const appName = usePage().props.appName
</script>

<template>
    <div class="mx-auto w-full max-w-6xl">
        <Breadcrumb>
            <BreadcrumbList>
                <BreadcrumbItem>
                    {{ appName }}
                </BreadcrumbItem>

                <BreadcrumbSeparator>
                    <Slash />
                </BreadcrumbSeparator>

                <slot />
            </BreadcrumbList>
        </Breadcrumb>
    </div>
</template>
