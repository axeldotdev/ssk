<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <p :class="cn('text-sm text-neutral-500 dark:text-neutral-400', props.class)">
    <slot />
  </p>
</template>
