<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })

interface EventItem {
    title: string
    excerpt?: string | null
    description?: string | null
    image_path?: string | null
    start_at?: string | null
    end_at?: string | null
    location?: string | null
    cta_text?: string | null
    cta_url?: string | null
}

interface BannerData {
    key: string
    title: string
    subtitle?: string | null
    content?: string | null
    image_path?: string | null
}

defineProps<{
    events: EventItem[]
    banner: BannerData | null
}>()
</script>

<template>
    <Head title="Eventos" />

    <section class="relative overflow-hidden bg-black">
        <img
            v-if="banner?.image_path"
            :src="banner.image_path"
            :alt="banner.title"
            class="absolute inset-0 h-full w-full object-cover opacity-30"
        />

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-20 md:px-6">
            <div v-if="events.length" class="grid gap-6 md:grid-cols-2">
                <article
                    v-for="event in events"
                    :key="event.title"
                    class="overflow-hidden rounded-3xl border border-white/10 bg-neutral-950"
                >
                    <img
                        v-if="event.image_path"
                        :src="event.image_path"
                        :alt="event.title"
                        class="h-64 w-full object-cover"
                    />

                    <div class="p-6">
                        <h2 class="text-2xl font-semibold text-white">{{ event.title }}</h2>
                        <p v-if="event.start_at" class="mt-2 text-sm text-amber-400">{{ event.start_at }}</p>
                        <p v-if="event.excerpt" class="mt-4 text-white/80">{{ event.excerpt }}</p>
                    </div>
                </article>
            </div>

            <div v-else class="flex min-h-[60vh] items-center justify-center">
                <img
                    v-if="banner?.image_path"
                    :src="banner.image_path"
                    :alt="banner.title"
                    class="w-full max-w-4xl object-contain"
                />
                <div v-else class="text-center text-white/70">
                    Próximamente
                </div>
            </div>
        </div>
    </section>
</template>
