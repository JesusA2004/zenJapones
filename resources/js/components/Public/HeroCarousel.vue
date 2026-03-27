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
    <section class="relative w-screen max-w-none overflow-hidden bg-black">
        <div class="relative h-[72svh] min-h-[420px] sm:h-[78svh] sm:min-h-[520px] md:h-[84svh] md:min-h-[650px] lg:h-screen lg:min-h-[820px] xl:min-h-[900px] w-screen max-w-none overflow-hidden bg-black">
            <div class="absolute inset-0 z-10 flex items-start justify-center px-4 pt-[15vh] sm:pt-[34vh] md:pt-[38vh] lg:items-center lg:pt-0">
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
                    class="absolute inset-0 block h-full w-full object-contain object-top select-none scale-[1] sm:scale-[1.02] md:scale-[1.05] lg:object-cover lg:object-center lg:scale-[1.08] xl:scale-[1.12] 2xl:scale-[1.15]"
                    style="filter: drop-shadow(0 20px 40px rgba(0,0,0,.35));"
                />
            </div>
        </div>
    </section>
</template>
