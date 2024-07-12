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

import OnboardingAccount from '@/Pages/Auth/Partials/OnboardingAccount.vue'
import OnboardingCompany from '@/Pages/Auth/Partials/OnboardingCompany.vue'
import OnboardingCollaborators from '@/Pages/Auth/Partials/OnboardingCollaborators.vue'

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

const submitAccountForm = () => {
    currentTab.value = 'company'
    activeTab.value = 'company'
}

const submitCompanyForm = () => {
    currentTab.value = 'collaborators'
    activeTab.value = 'collaborators'
}
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
                <OnboardingAccount @submit="submitAccountForm"></OnboardingAccount>
            </TabsContent>
            <TabsContent value="company">
                <OnboardingCompany @submit="submitCompanyForm"></OnboardingCompany>
            </TabsContent>
            <TabsContent value="collaborators">
                <OnboardingCollaborators></OnboardingCollaborators>
            </TabsContent>
        </Tabs>
    </GuestLayout>
</template>
