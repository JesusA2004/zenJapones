<script setup lang="ts">
interface Slide {
    title?: string | null
    subtitle?: string | null
    image: string | null
    cta?: string | null
    ctaHref?: string | null
}

const props = defineProps<{
    slides: Slide[]
}>()
</script>

<template>
    <section class="relative w-full overflow-hidden bg-black">
        <div class="relative h-screen min-h-[900px] w-full overflow-hidden bg-black">
            <div class="absolute inset-0 z-10 flex items-center justify-center px-4">
                <h1
                    class="pointer-events-none text-center uppercase leading-[0.88] tracking-[0.01em] text-white text-[clamp(5rem,15vw,14rem)]"
                    style="font-family: 'Japanese3017', sans-serif !important;"
                >
                    ZEN JAPONES
                </h1>
            </div>

            <div
                v-if="props.slides?.length && props.slides[0]?.image"
                class="pointer-events-none absolute inset-0 z-20 overflow-hidden"
            >
                <img
                    :src="props.slides[0].image || ''"
                    :alt="props.slides[0].title || 'Hero principal'"
                    class="absolute left-1/2 top-1/2 block h-full w-full max-w-none -translate-x-1/2 -translate-y-1/2 scale-[1.15] object-cover select-none"
                    style="filter: drop-shadow(0 20px 40px rgba(0,0,0,.35));"
                />
            </div>
        </div>
    </section>
</template>
