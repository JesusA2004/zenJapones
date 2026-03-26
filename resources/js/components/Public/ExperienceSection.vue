<script setup lang="ts">
interface SectionData {
    key: string
    title: string
    subtitle?: string | null
    content?: string | null
    image_path?: string | null
}

defineProps<{
    section: SectionData
}>()
</script>

<template>
    <section class="relative flex min-h-[70vh] items-center overflow-hidden border-b border-white/10 bg-black">
        <img
            v-if="section.image_path"
            :src="section.image_path"
            :alt="section.title"
            class="absolute inset-0 h-full w-full object-cover opacity-70"
        />
        <div class="absolute inset-0 bg-black/35"></div>

        <div class="relative z-10 mx-auto flex w-full max-w-7xl justify-end px-4 py-20 md:px-6">
            <div class="max-w-3xl text-right">
                <p v-if="section.subtitle" class="text-3xl font-semibold uppercase tracking-[0.2em] text-white md:text-5xl">
                    {{ section.subtitle }}
                </p>
                <h2 class="mt-1 text-5xl font-bold text-amber-400 md:text-7xl">
                    {{ section.title }}
                </h2>
                <p v-if="section.content" class="mt-6 text-base leading-8 text-white/90 md:text-lg">
                    {{ section.content }}
                </p>
            </div>
        </div>
    </section>
</template>
