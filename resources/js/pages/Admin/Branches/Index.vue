<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import ImageUploader from '@/components/Admin/ImageUploader.vue'
import { useForm, router } from '@inertiajs/vue3'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, {}, () => page),
})

const props = defineProps<{
    branches: Array<Record<string, any>>
}>()

const createForm = useForm({
    name: '',
    phone: '',
    whatsapp: '',
    email: '',
    address: '',
    city: '',
    state: '',
    postal_code: '',
    maps_url: '',
    hours_text: '',
    description: '',
    image: null as File | null,
    sort_order: 0,
    is_active: true,
})

function createBranch() {
    createForm.post('/admin/sucursales', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => createForm.reset(),
    })
}

function updateBranch(branch: any) {
    const form = useForm({
        name: branch.name ?? '',
        phone: branch.phone ?? '',
        whatsapp: branch.whatsapp ?? '',
        email: branch.email ?? '',
        address: branch.address ?? '',
        city: branch.city ?? '',
        state: branch.state ?? '',
        postal_code: branch.postal_code ?? '',
        maps_url: branch.maps_url ?? '',
        hours_text: branch.hours_text ?? '',
        description: branch.description ?? '',
        image: null as File | null,
        sort_order: branch.sort_order ?? 0,
        is_active: branch.is_active ?? true,
    })

    form.post(`/admin/sucursales/${branch.id}`, {
        forceFormData: true,
        preserveScroll: true,
    })
}

function destroyBranch(id: number) {
    router.delete(`/admin/sucursales/${id}`, {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="grid gap-6 xl:grid-cols-[430px_1fr]">
        <form @submit.prevent="createBranch" class="space-y-4 rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl">
            <h2 class="text-xl font-semibold text-white">Nueva sucursal</h2>
            <input v-model="createForm.name" placeholder="Nombre" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <input v-model="createForm.phone" placeholder="Teléfono" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <input v-model="createForm.whatsapp" placeholder="WhatsApp" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <input v-model="createForm.email" placeholder="Correo" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <textarea v-model="createForm.address" rows="3" placeholder="Dirección" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <div class="grid gap-4 md:grid-cols-2">
                <input v-model="createForm.city" placeholder="Ciudad" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="createForm.state" placeholder="Estado" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <input v-model="createForm.postal_code" placeholder="CP" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="createForm.sort_order" type="number" placeholder="Orden" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            </div>
            <input v-model="createForm.maps_url" placeholder="URL Maps" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <textarea v-model="createForm.hours_text" rows="3" placeholder="Horario" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <textarea v-model="createForm.description" rows="3" placeholder="Descripción" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />

            <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                <input v-model="createForm.is_active" type="checkbox" />
                Activa
            </label>

            <ImageUploader @selected="createForm.image = $event" />

            <button class="w-full rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-black">Guardar sucursal</button>
        </form>

        <div class="grid gap-5 md:grid-cols-2">
            <div v-for="branch in branches" :key="branch.id" class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl">
                <ImageUploader :preview="branch.image_url" @selected="branch.image = $event" />
                <div class="mt-4 grid gap-3">
                    <input v-model="branch.name" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <input v-model="branch.phone" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <input v-model="branch.whatsapp" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <input v-model="branch.email" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <textarea v-model="branch.address" rows="3" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <textarea v-model="branch.hours_text" rows="3" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <input v-model="branch.maps_url" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <input v-model="branch.sort_order" type="number" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                        <input v-model="branch.is_active" type="checkbox" />
                        Activa
                    </label>

                    <div class="grid grid-cols-2 gap-3">
                        <button @click="updateBranch(branch)" type="button" class="rounded-2xl bg-emerald-500 px-4 py-3 font-semibold text-white">
                            Guardar
                        </button>
                        <button @click="destroyBranch(branch.id)" type="button" class="rounded-2xl bg-rose-500 px-4 py-3 font-semibold text-white">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
