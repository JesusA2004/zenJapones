<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import HeroCarousel from '@/components/Public/HeroCarousel.vue'
import ConceptSection from '@/components/Public/ConceptSection.vue'
import ExperienceSection from '@/components/Public/ExperienceSection.vue'
import BarSection from '@/components/Public/BarSection.vue'
import MenuPreviewSection from '@/components/Public/MenuPreviewSection.vue'
import BranchCard from '@/components/Public/BranchCard.vue'
import SectionTitle from '@/components/Public/SectionTitle.vue'

defineOptions({ layout: PublicLayout })

const slides = [
    {
        title: 'ZEN JAPONÉS',
        subtitle: 'Mismo concepto visual del sitio actual, pero reconstruido con mejor arquitectura, mejor menú y panel administrativo moderno.',
        image: 'https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?auto=format&fit=crop&w=1600&q=80',
        cta: 'Ver menú',
        ctaHref: '/menu',
    },
]

const featuredItems = [
    {
        name: 'Ramen Especial',
        description: 'Caldo profundo, proteína seleccionada, vegetales frescos y presentación premium.',
        price: '$210',
        image: 'https://images.unsplash.com/photo-1557872943-16a5ac26437e?auto=format&fit=crop&w=1200&q=80',
        badge: 'Destacado',
    },
    {
        name: 'Sushi Roll Signature',
        description: 'Combinación equilibrada de sabor, textura e imagen para una experiencia memorable.',
        price: '$185',
        image: 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=1200&q=80',
        badge: 'Popular',
    },
    {
        name: 'Coctel de la casa',
        description: 'Una propuesta visual y sensorial que acompaña el concepto del restaurante.',
        price: '$160',
        image: 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=1200&q=80',
        badge: 'Bar',
    },
]

const branches = [
    {
        name: 'Zen Río Mayo',
        phone: '777 123 4567',
        address: 'Av. Río Mayo, Cuernavaca, Morelos',
        hours: 'Lun a Dom · 1:00 pm a 11:00 pm',
        image: 'https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=1200&q=80',
        mapsUrl: 'https://maps.google.com',
    },
    {
        name: 'Zen Averanda',
        phone: '777 987 6543',
        address: 'Av. Plan de Ayala, Cuernavaca, Morelos',
        hours: 'Lun a Dom · 1:00 pm a 11:00 pm',
        image: 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80',
        mapsUrl: 'https://maps.google.com',
    },
]
</script>

<template>
    <Head title="Zen Japonés" />

    <HeroCarousel :slides="slides" />
    <ConceptSection />
    <ExperienceSection />
    <BarSection />
    <MenuPreviewSection :items="featuredItems" />

    <section class="bg-neutral-950">
        <div class="mx-auto max-w-7xl px-4 py-20 md:px-6">
            <SectionTitle
                eyebrow="Sucursales"
                title="Conoce nuestras ubicaciones"
                description="La misma información del sitio actual, pero presentada de forma más limpia y modular."
            />

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <BranchCard v-for="branch in branches" :key="branch.name" :branch="branch" />
            </div>
        </div>
    </section>
</template>
