<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <span
    :class="
      cn(
        'ml-auto text-xs tracking-widest text-neutral-500 dark:text-neutral-400',
        props.class,
      )
    "
  >
    <slot />
  </span>
</template>
