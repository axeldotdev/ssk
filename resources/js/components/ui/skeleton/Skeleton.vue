<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
  class: { type: null, required: false },
});
</script>

<template>
  <div
    :class="
      cn(
        'animate-pulse rounded-md bg-neutral-100 dark:bg-neutral-800',
        props.class,
      )
    "
  />
</template>
