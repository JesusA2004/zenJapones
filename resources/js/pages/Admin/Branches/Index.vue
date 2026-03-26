<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, { title: 'Sucursales' }, () => page),
})

const branches = [
    { name: 'Zen Río Mayo', phone: '777 123 4567', status: 'Activa' },
    { name: 'Zen Averanda', phone: '777 987 6543', status: 'Activa' },
]
</script>

<template>
    <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white">Gestión de sucursales</h2>
            <button class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-semibold text-black">
                Nueva sucursal
            </button>
        </div>

        <div class="grid gap-4">
            <div
                v-for="branch in branches"
                :key="branch.name"
                class="flex items-center justify-between rounded-2xl border border-neutral-800 bg-black/40 p-5"
            >
                <div>
                    <h3 class="text-lg font-semibold text-white">{{ branch.name }}</h3>
                    <p class="mt-1 text-sm text-neutral-400">{{ branch.phone }}</p>
                </div>

                <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs text-emerald-400">
                    {{ branch.status }}
                </span>
            </div>
        </div>
    </div>
</template>
