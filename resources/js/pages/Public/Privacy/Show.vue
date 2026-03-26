<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })

interface BannerData {
    key: string
    title: string
    subtitle?: string | null
    content?: string | null
    image_path?: string | null
}

defineProps<{
    content?: string | null
    banner: BannerData | null
}>()
</script>

<template>
    <Head title="Aviso de privacidad" />

    <section class="bg-black">
        <div class="relative">
            <img
                v-if="banner?.image_path"
                :src="banner.image_path"
                :alt="banner.title"
                class="h-[320px] w-full object-cover opacity-80"
            />

            <div class="absolute bottom-4 left-4">
                <a
                    href="/"
                    class="inline-flex rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-black"
                >
                    CONTÁCTANOS
                </a>
            </div>
        </div>

        <div class="mx-auto max-w-5xl px-4 py-16 md:px-6">
            <h1 class="mb-8 text-center text-4xl font-semibold tracking-[0.18em] text-white">
                AVISO DE PRIVACIDAD
            </h1>

            <div class="rounded-3xl border border-white/10 bg-neutral-950 p-8 text-sm leading-8 text-white/90 whitespace-pre-line">
                {{ content }}
            </div>
        </div>
    </section>
</template>
