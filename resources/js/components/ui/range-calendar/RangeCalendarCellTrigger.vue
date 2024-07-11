<script setup>
import { computed } from "vue";
import { RangeCalendarCellTrigger, useForwardProps } from "radix-vue";
import { buttonVariants } from "@/components/ui/button";
import { cn } from "@/lib/utils";

const props = defineProps({
  day: { type: null, required: true },
  month: { type: null, required: true },
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
  <RangeCalendarCellTrigger
    :class="
      cn(
        buttonVariants({ variant: 'ghost' }),
        'h-9 w-9 p-0 font-normal data-[selected]:opacity-100',
        '[&[data-today]:not([data-selected])]:bg-neutral-100 [&[data-today]:not([data-selected])]:text-neutral-900 dark:[&[data-today]:not([data-selected])]:bg-neutral-800 dark:[&[data-today]:not([data-selected])]:text-neutral-50',
        // Selection Start
        'data-[selection-start]:bg-neutral-900 data-[selection-start]:text-neutral-50 data-[selection-start]:hover:bg-neutral-900 data-[selection-start]:hover:text-neutral-50 data-[selection-start]:focus:bg-neutral-900 data-[selection-start]:focus:text-neutral-50 dark:data-[selection-start]:bg-neutral-50 dark:data-[selection-start]:text-neutral-900 dark:data-[selection-start]:hover:bg-neutral-50 dark:data-[selection-start]:hover:text-neutral-900 dark:data-[selection-start]:focus:bg-neutral-50 dark:data-[selection-start]:focus:text-neutral-900',
        // Selection End
        'data-[selection-end]:bg-neutral-900 data-[selection-end]:text-neutral-50 data-[selection-end]:hover:bg-neutral-900 data-[selection-end]:hover:text-neutral-50 data-[selection-end]:focus:bg-neutral-900 data-[selection-end]:focus:text-neutral-50 dark:data-[selection-end]:bg-neutral-50 dark:data-[selection-end]:text-neutral-900 dark:data-[selection-end]:hover:bg-neutral-50 dark:data-[selection-end]:hover:text-neutral-900 dark:data-[selection-end]:focus:bg-neutral-50 dark:data-[selection-end]:focus:text-neutral-900',
        // Outside months
        'data-[outside-month]:pointer-events-none data-[outside-month]:text-neutral-500 data-[outside-month]:opacity-50 [&[data-outside-month][data-selected]]:bg-neutral-100/50 [&[data-outside-month][data-selected]]:text-neutral-500 [&[data-outside-month][data-selected]]:opacity-30 dark:data-[outside-month]:text-neutral-400 dark:[&[data-outside-month][data-selected]]:bg-neutral-800/50 dark:[&[data-outside-month][data-selected]]:text-neutral-400',
        // Disabled
        'data-[disabled]:text-neutral-500 data-[disabled]:opacity-50 dark:data-[disabled]:text-neutral-400',
        // Unavailable
        'data-[unavailable]:text-neutral-50 data-[unavailable]:line-through dark:data-[unavailable]:text-neutral-50',
        props.class,
      )
    "
    v-bind="forwardedProps"
  >
    <slot />
  </RangeCalendarCellTrigger>
</template>
