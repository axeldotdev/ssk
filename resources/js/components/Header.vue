<script setup></script>

<template>
    <div class="mx-auto flex justify-between items-center w-full max-w-6xl gap-2">
        <div>
            <h1 class="text-3xl font-semibold text-neutral-800">
                <slot />
            </h1>
        </div>

        <div>
            <slot name="actions" />
        </div>
    </div>
</template>
