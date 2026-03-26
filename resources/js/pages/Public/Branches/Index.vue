<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import SectionTitle from '@/components/Public/SectionTitle.vue'
import BranchCard from '@/components/Public/BranchCard.vue'

defineOptions({ layout: PublicLayout })

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
    <Head title="Sucursales" />

    <section class="bg-black">
        <div class="mx-auto max-w-7xl px-4 py-20 md:px-6">
            <SectionTitle
                eyebrow="Sucursales"
                title="Encuentra tu sucursal más cercana"
                description="Bloques independientes, más claros y mejor organizados que en la versión anterior."
            />

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <BranchCard v-for="branch in branches" :key="branch.name" :branch="branch" />
            </div>
        </div>
    </section>
</template>
