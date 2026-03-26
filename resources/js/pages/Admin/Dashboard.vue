<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import PublishButton from '@/components/Admin/PublishButton.vue'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, {}, () => page),
})

defineProps<{
    stats: {
        heroSlides: number
        sections: number
        branches: number
        events: number
        categories: number
        menuItems: number
        menuVersion: number
    }
    latestPublication?: {
        version_number: number
        notes?: string | null
        created_at?: string
    } | null
}>()
</script>

<template>
    <div class="space-y-6">
        <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-white/10 to-white/5 p-6 shadow-2xl sm:p-8">
            <p class="text-xs uppercase tracking-[0.3em] text-amber-400">Administrador</p>
            <h2 class="mt-3 text-3xl font-semibold text-white sm:text-4xl">Panel principal</h2>
            <p class="mt-3 max-w-3xl text-sm leading-7 text-white/70 sm:text-base">
                Administra el contenido del sitio, hero, secciones, menú, sucursales y eventos desde un solo lugar.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl" v-for="card in [
                ['Hero slides', stats.heroSlides],
                ['Secciones', stats.sections],
                ['Sucursales', stats.branches],
                ['Eventos', stats.events],
                ['Categorías', stats.categories],
                ['Platillos', stats.menuItems],
            ]" :key="card[0]">
                <p class="text-sm text-white/60">{{ card[0] }}</p>
                <p class="mt-3 text-3xl font-bold text-white">{{ card[1] }}</p>
            </div>
        </div>

        <PublishButton :version="stats.menuVersion" />

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 shadow-xl">
            <h3 class="text-xl font-semibold text-white">Última publicación</h3>
            <div v-if="latestPublication" class="mt-4 space-y-2 text-sm text-white/75">
                <p><span class="font-semibold text-white">Versión:</span> v{{ latestPublication.version_number }}</p>
                <p v-if="latestPublication.notes"><span class="font-semibold text-white">Notas:</span> {{ latestPublication.notes }}</p>
            </div>
            <p v-else class="mt-4 text-sm text-white/60">Aún no hay publicaciones registradas.</p>
        </div>
    </div>
</template>
