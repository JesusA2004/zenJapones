<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

interface SectionData {
    key: string
    title: string
    subtitle?: string | null
    content?: string | null
    image_path?: string | null
    extra_json?: Record<string, unknown> | null
}

defineProps<{
    section: SectionData
}>()
</script>

<template>
    <section class="relative border-b border-white/10 bg-black">
        <img
            src="/images/decor/bg-lines.webp"
            alt="Líneas decorativas"
            class="absolute left-0 top-0 h-full w-full object-cover opacity-10"
        />

        <div class="relative z-10 mx-auto grid min-h-[70vh] max-w-7xl items-center gap-10 px-4 py-20 md:grid-cols-[0.7fr_1.3fr] md:px-6">
            <div class="order-2 flex justify-center md:order-1">
                <img
                    v-if="section.image_path"
                    :src="section.image_path"
                    :alt="section.title"
                    class="max-h-[460px] w-full max-w-md object-contain"
                />
            </div>

            <div class="order-1 text-right md:order-2">
                <h2 class="text-4xl font-semibold tracking-[0.2em] text-white md:text-6xl">
                    {{ section.title }}
                </h2>
                <p v-if="section.content" class="mt-6 ml-auto max-w-2xl text-base leading-8 text-white/90 md:text-lg">
                    {{ section.content }}
                </p>

                <div class="mt-8">
                    <Link
                        :href="String(section.extra_json?.button_url || '/sucursales')"
                        class="inline-flex rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-black transition hover:scale-[1.02]"
                    >
                        {{ String(section.extra_json?.button_text || 'Conócenos') }}
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
