<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import PublishButton from '@/components/Admin/PublishButton.vue'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, { title: 'Dashboard' }, () => page),
})

function publishMenu() {
    console.log('Publicar cambios del menú')
}
</script>

<template>
    <div class="space-y-6">
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
                <p class="text-sm text-neutral-400">Sucursales</p>
                <p class="mt-3 text-3xl font-bold text-white">2</p>
            </div>
            <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
                <p class="text-sm text-neutral-400">Categorías de menú</p>
                <p class="mt-3 text-3xl font-bold text-white">6</p>
            </div>
            <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
                <p class="text-sm text-neutral-400">Platillos</p>
                <p class="mt-3 text-3xl font-bold text-white">24</p>
            </div>
        </div>

        <PublishButton version="v1.0.0" @publish="publishMenu" />
    </div>
</template>
