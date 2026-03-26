<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import HeroCarousel from '@/components/Public/HeroCarousel.vue'
import ConceptSection from '@/components/Public/ConceptSection.vue'
import ExperienceSection from '@/components/Public/ExperienceSection.vue'
import BarSection from '@/components/Public/BarSection.vue'
import MenuPreviewSection from '@/components/Public/MenuPreviewSection.vue'

defineOptions({ layout: PublicLayout })

interface Slide {
    title?: string | null
    subtitle?: string | null
    image: string | null
    cta?: string | null
    ctaHref?: string | null
}

interface SectionData {
    key: string
    title: string
    subtitle?: string | null
    content?: string | null
    image_path?: string | null
    extra_json?: Record<string, unknown> | null
}

defineProps<{
    slides: Slide[]
    conceptSection: SectionData | null
    experienceSection: SectionData | null
    barSection: SectionData | null
    menuCtaSection: SectionData | null
}>()
</script>

<template>
    <Head title="" />

    <HeroCarousel :slides="slides" />

    <ConceptSection v-if="conceptSection" :section="conceptSection" />
    <ExperienceSection v-if="experienceSection" :section="experienceSection" />
    <BarSection v-if="barSection" :section="barSection" />
    <MenuPreviewSection v-if="menuCtaSection" :section="menuCtaSection" />
</template>
