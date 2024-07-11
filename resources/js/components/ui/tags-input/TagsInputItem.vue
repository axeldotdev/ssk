<script setup>
import { computed } from "vue";
import { TagsInputItem, useForwardProps } from "radix-vue";

import { cn } from "@/lib/utils";

const props = defineProps({
  value: { type: [String, Object], required: true },
  disabled: { type: Boolean, required: false },
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
  <TagsInputItem
    v-bind="forwardedProps"
    :class="
      cn(
        'flex h-6 items-center rounded bg-neutral-100 data-[state=active]:ring-neutral-950 data-[state=active]:ring-2 data-[state=active]:ring-offset-2 ring-offset-white dark:bg-neutral-800 dark:data-[state=active]:ring-neutral-300 dark:ring-offset-neutral-950',
        props.class,
      )
    "
  >
    <slot />
  </TagsInputItem>
</template>
