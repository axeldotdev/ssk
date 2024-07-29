<script setup>
import { router } from '@inertiajs/vue3'

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
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'

defineProps({
    passkeys: {
        type: Array,
    },
})

const submitRevokePasskeyForm = (passkey) => {
    router.delete(route('passkeys.destroy', passkey))
}
</script>

<template>
    <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[320px_1fr]">
        <div class="grid gap-2 text-sm">
            <h2 class="text-xl font-semibold text-neutral-800">
                {{ $t('Manage passkeys') }}
            </h2>
            <p class="text-neutral-500">
                {{ $t('Manage your passkeys for passwordless authentication.') }}
            </p>
        </div>
        <div class="grid gap-6">
            <Card>
                <CardContent class="pt-8">
                    <template v-for="passkey in passkeys" :key="passkey.id">
                        <div>
                            <div class="p-3 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="ms-2">
                                        <div class="text-sm font-semibold text-neutral-600 dark:text-neutral-400">
                                            {{ passkey.name }}
                                        </div>

                                        <div class="text-xs text-neutral-500">
                                            {{ $t('Added') }} {{ passkey.created_at }}
                                        </div>
                                    </div>
                                </div>

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
                                                {{ $t('This action cannot be undone. This will permanently delete your passkey.') }}
                                            </AlertDialogDescription>
                                        </AlertDialogHeader>
                                        <AlertDialogFooter>
                                            <AlertDialogCancel>
                                                {{ $t('Cancel') }}
                                            </AlertDialogCancel>
                                            <AlertDialogAction @click="submitRevokePasskeyForm(passkey.id)" class="bg-red-500 hover:bg-red-500/90">
                                                {{ $t('Revoke') }}
                                            </AlertDialogAction>
                                        </AlertDialogFooter>
                                    </AlertDialogContent>
                                </AlertDialog>
                            </div>
                        </div>
                    </template>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
