<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import SectionTitle from '@/components/Public/SectionTitle.vue'

defineOptions({ layout: PublicLayout })

const events = [
    {
        title: 'Noche de sake',
        date: 'Viernes 28 · 8:00 pm',
        description: 'Experiencia especial con ambientación y selección de bebidas.',
    },
    {
        title: 'Cena temática',
        date: 'Sábado 12 · 9:00 pm',
        description: 'Una experiencia gastronómica con propuesta visual destacada.',
    },
]
</script>

<template>
    <Head title="Eventos" />

    <section class="bg-neutral-950">
        <div class="mx-auto max-w-7xl px-4 py-20 md:px-6">
            <SectionTitle
                eyebrow="Eventos"
                title="Experiencias especiales"
                description="Página preparada para publicar eventos del restaurante, próximos lanzamientos y experiencias destacadas."
            />

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <article
                    v-for="event in events"
                    :key="event.title"
                    class="rounded-3xl border border-white/10 bg-black p-6"
                >
                    <p class="text-xs uppercase tracking-[0.25em] text-amber-400">{{ event.date }}</p>
                    <h3 class="mt-3 text-2xl font-semibold text-white">{{ event.title }}</h3>
                    <p class="mt-4 text-sm leading-7 text-neutral-300">{{ event.description }}</p>
                </article>
            </div>
        </div>
    </section>
</template>
