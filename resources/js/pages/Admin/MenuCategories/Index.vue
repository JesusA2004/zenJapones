<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, { title: 'Categorías de menú' }, () => page),
})

const categories = [
    { name: 'Ramen', items: 8, active: true },
    { name: 'Sushi', items: 7, active: true },
    { name: 'Entradas', items: 5, active: true },
    { name: 'Bebidas', items: 4, active: true },
]
</script>

<template>
    <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white">Listado de categorías</h2>
            <button class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-semibold text-black">
                Nueva categoría
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="text-neutral-400">
                    <tr class="border-b border-neutral-800">
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Platillos</th>
                        <th class="px-4 py-3">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories" :key="category.name" class="border-b border-neutral-800/70 text-neutral-200">
                        <td class="px-4 py-4">{{ category.name }}</td>
                        <td class="px-4 py-4">{{ category.items }}</td>
                        <td class="px-4 py-4">
                            <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs text-emerald-400">
                                {{ category.active ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
