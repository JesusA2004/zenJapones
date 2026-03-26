<script setup lang="ts">
import { reactive } from 'vue'
import AdminLayout from '@/layouts/AdminLayout.vue'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, { title: 'Configuración general' }, () => page),
})

const form = reactive({
    restaurantName: 'Zen Japonés',
    contactEmail: 'contacto@zenjapones.com',
    phone: '777 000 0000',
    menuVersion: 'v1.0.0',
})

function saveSettings() {
    console.log('Guardar settings', form)
}
</script>

<template>
    <form @submit.prevent="saveSettings" class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-medium text-white">Nombre del restaurante</label>
                <input
                    v-model="form.restaurantName"
                    type="text"
                    class="w-full rounded-xl border border-neutral-700 bg-black px-4 py-3 text-white outline-none transition focus:border-amber-400"
                />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-white">Correo de contacto</label>
                <input
                    v-model="form.contactEmail"
                    type="email"
                    class="w-full rounded-xl border border-neutral-700 bg-black px-4 py-3 text-white outline-none transition focus:border-amber-400"
                />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-white">Teléfono</label>
                <input
                    v-model="form.phone"
                    type="text"
                    class="w-full rounded-xl border border-neutral-700 bg-black px-4 py-3 text-white outline-none transition focus:border-amber-400"
                />
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-white">Versión actual del menú</label>
                <input
                    v-model="form.menuVersion"
                    type="text"
                    class="w-full rounded-xl border border-neutral-700 bg-black px-4 py-3 text-white outline-none transition focus:border-amber-400"
                />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-semibold text-black">
                Guardar configuración
            </button>
        </div>
    </form>
</template>
