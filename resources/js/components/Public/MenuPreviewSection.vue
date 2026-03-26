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
    <section class="relative flex min-h-[70vh] items-center overflow-hidden border-b border-white/10 bg-black">
        <img
            v-if="section.image_path"
            :src="section.image_path"
            :alt="section.title"
            class="absolute inset-0 h-full w-full object-cover opacity-75"
        />
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative z-10 mx-auto flex w-full max-w-7xl justify-end px-4 py-20 md:px-6">
            <div class="text-right">
                <p v-if="section.subtitle" class="text-3xl font-semibold uppercase tracking-[0.18em] text-white md:text-5xl">
                    {{ section.subtitle }}
                </p>
                <h2 class="mt-2 text-5xl font-bold text-amber-400 md:text-7xl">
                    {{ section.title }}
                </h2>

                <div class="mt-8">
                    <Link
                        :href="String(section.extra_json?.button_url || '/menu')"
                        class="inline-flex rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-black transition hover:scale-[1.02]"
                    >
                        {{ String(section.extra_json?.button_text || 'MENÚ') }}
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
