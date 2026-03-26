<script setup lang="ts">
defineProps<{
    eyebrow?: string
    title: string
    description?: string
    centered?: boolean
}>()
</script>

<template>
    <div :class="centered ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl'">
        <p v-if="eyebrow" class="text-sm uppercase tracking-[0.35em] text-amber-400">
            {{ eyebrow }}
        </p>
        <h2 class="mt-3 text-3xl font-semibold text-white md:text-5xl">
            {{ title }}
        </h2>
        <p v-if="description" class="mt-4 text-base leading-7 text-neutral-300">
            {{ description }}
        </p>
    </div>
</template>
