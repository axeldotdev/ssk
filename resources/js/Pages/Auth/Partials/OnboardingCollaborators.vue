<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useForm } from 'laravel-precognition-vue-inertia'

import { Plus, Trash2 } from 'lucide-vue-next'

import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import ErrorMessage from '@/components/ErrorMessage.vue'

const emails = ref([''])

const collaboratorsForm = useForm('post', route('onboarding.collaborators'), {
    emails: emails,
})

const addEmail = () => emails.value.push('')

const removeEmail = (index) => emails.value.splice(index, 1)

const submitCollaboratorsForm = () => collaboratorsForm.submit()
</script>

<template>
    <Card class="mx-auto w-128">
        <CardHeader>
            <CardTitle class="text-xl">
                {{ $t('Invite your collaborators') }}
            </CardTitle>
            <CardDescription>
                {{ $t('Send an invitation to your collaborators to join you.') }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submitCollaboratorsForm" class="grid gap-4">
                <div
                    v-for="(email, index) in emails"
                    :key="index"
                    class="grid gap-2">
                    <Label for="email">
                        {{ $t('Collaborator') }} {{ index + 1 }}
                    </Label>

                    <div class="flex gap-2">
                        <Input
                            v-model="emails[index]"
                            @change="companyForm.validate('emails')"
                            :id="`email_${index}`"
                            type="email"
                            placeholder="support@orvea.io" />

                        <Button
                            @click="removeEmail(index)"
                            variant="destructive"
                            size="icon"
                            type="button"
                            class="shrink-0">
                            <span class="sr-only">
                                {{ $t('Remove collaborator') }}
                            </span>
                            <Trash2 class="w-4 h-4" />
                        </Button>

                        <Button
                            v-if="index + 1 === emails.length"
                            @click="addEmail"
                            variant="secondary"
                            size="icon"
                            type="button"
                            class="shrink-0">
                            <span class="sr-only">
                                {{ $t('Add collaborator') }}
                            </span>
                            <Plus class="w-4 h-4" />
                        </Button>
                        <Button
                            v-else
                            disabled
                            variant="ghost"
                            size="icon"
                            type="button"
                            class="shrink-0"></Button>
                    </div>

                    <ErrorMessage v-if="collaboratorsForm.invalid('emails')">
                        {{ collaboratorsForm.errors.emails }}
                    </ErrorMessage>
                </div>

                <Button :disabled="collaboratorsForm.processing" type="submit">
                    {{ emails.length > 1 ? $t('Send invitations') : $t('Send invitation') }}
                </Button>

                <Button variant="outline" as-child>
                    <Link :href="route('onboarding.skip')">
                        {{ $t('Skip') }}
                    </Link>
                </Button>
            </form>
        </CardContent>
    </Card>
</template>
