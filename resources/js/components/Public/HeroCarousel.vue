<script setup lang="ts">
interface Slide {
    title: string
    subtitle: string
    image: string
    cta?: string
    ctaHref?: string
}

defineProps<{
    slides: Slide[]
}>()
</script>

<template>
    <section class="relative overflow-hidden">
        <div
            v-for="(slide, index) in slides"
            :key="index"
            class="relative min-h-[78vh] border-b border-white/10"
        >
            <div class="absolute inset-0">
                <img :src="slide.image" :alt="slide.title" class="h-full w-full object-cover opacity-45" />
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/60 to-black"></div>
            </div>

            <div class="relative mx-auto flex min-h-[78vh] max-w-7xl items-center px-4 py-20 md:px-6">
                <div class="max-w-3xl">
                    <p class="mb-4 text-sm uppercase tracking-[0.35em] text-amber-400">
                        Cocina japonesa contemporánea
                    </p>
                    <h1 class="text-5xl font-bold uppercase leading-none text-white md:text-7xl">
                        {{ slide.title }}
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-7 text-neutral-200 md:text-lg">
                        {{ slide.subtitle }}
                    </p>

                    <div class="mt-8" v-if="slide.cta && slide.ctaHref">
                        <a
                            :href="slide.ctaHref"
                            class="inline-flex rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-black transition hover:scale-[1.02]"
                        >
                            {{ slide.cta }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
