<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import MenuItemForm from '@/components/Admin/MenuItemForm.vue'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, { title: 'Platillos del menú' }, () => page),
})

const items = [
    { name: 'Ramen Tonkotsu', category: 'Ramen', price: '$210', status: 'Disponible' },
    { name: 'Roll Zen', category: 'Sushi', price: '$185', status: 'Disponible' },
    { name: 'Gyozas', category: 'Entradas', price: '$120', status: 'Disponible' },
]

function handleSubmit(payload: Record<string, unknown>) {
    console.log('Guardar item:', payload)
}
</script>

<template>
    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
            <h2 class="mb-6 text-xl font-semibold text-white">Listado de platillos</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="text-neutral-400">
                        <tr class="border-b border-neutral-800">
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Categoría</th>
                            <th class="px-4 py-3">Precio</th>
                            <th class="px-4 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items" :key="item.name" class="border-b border-neutral-800/70 text-neutral-200">
                            <td class="px-4 py-4">{{ item.name }}</td>
                            <td class="px-4 py-4">{{ item.category }}</td>
                            <td class="px-4 py-4">{{ item.price }}</td>
                            <td class="px-4 py-4">{{ item.status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <MenuItemForm @submit="handleSubmit" />
    </div>
</template>
