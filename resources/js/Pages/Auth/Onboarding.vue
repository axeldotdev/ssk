<script setup>
import { ref, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'

import GuestLayout from '@/Layouts/GuestLayout.vue'

import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/components/ui/tabs'

const props = defineProps({
    signUpMethod: {
        type: String,
    },
    onboardingStep: {
        type: String,
    },
})

const currentTab = ref(props.onboardingStep)

const activeTab = ref('account')

onMounted(() => {
    if (props.onboardingStep === 'company') {
        activeTab.value = 'company'
    } else if (props.onboardingStep === 'collaborators') {
        activeTab.value = 'collaborators'
    }
})
</script>

<template>
    <Head :title="$t('Onboarding')" />

    <GuestLayout>
        <Tabs default-value="account" v-model="currentTab" class="w-128">
            <TabsList class="grid w-full grid-cols-3">
                <TabsTrigger value="account">
                    {{ $t('Account') }}
                </TabsTrigger>
                <TabsTrigger
                    :disabled="activeTab === 'account'"
                    value="company">
                    {{ $t('Company') }}
                </TabsTrigger>
                <TabsTrigger
                    :disabled="activeTab !== 'collaborators'"
                    value="collaborators">
                    {{ $t('Collaborators') }}
                </TabsTrigger>
            </TabsList>
            <TabsContent value="account">
                <OnboardingAccount></OnboardingAccount>
            </TabsContent>
            <TabsContent value="company">
                <OnboardingCompany></OnboardingCompany>
            </TabsContent>
            <TabsContent value="collaborators">
                <OnboardingCollaborators></OnboardingCollaborators>
            </TabsContent>
        </Tabs>
    </GuestLayout>
</template>
