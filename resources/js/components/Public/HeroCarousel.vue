<script setup lang="ts">
interface Slide {
    title?: string | null
    subtitle?: string | null
    image: string | null
    cta?: string | null
    ctaHref?: string | null
}

defineProps<{
    slides: Slide[]
}>()
</script>

<template>
    <section class="relative overflow-hidden border-b border-white/10 bg-black">
        <div class="relative min-h-[78vh]">
            <div class="absolute inset-0 grid grid-cols-1 md:grid-cols-3">
                <div v-for="(slide, index) in slides" :key="index" class="relative">
                    <img
                        v-if="slide.image"
                        :src="slide.image"
                        :alt="slide.title || `Slide ${index + 1}`"
                        class="h-full w-full object-cover opacity-90"
                    />
                    <div class="absolute inset-0 bg-black/25"></div>
                </div>
            </div>

            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/40"></div>

            <div class="relative mx-auto flex min-h-[78vh] max-w-7xl items-end justify-center px-4 pb-16 md:px-6">
                <h1 class="text-center text-5xl font-bold tracking-[0.14em] text-white md:text-8xl">
                    ZEN JAPONES
                </h1>
            </div>
        </div>
    </section>
</template>
