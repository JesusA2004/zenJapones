<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import ImageUploader from '@/components/Admin/ImageUploader.vue'
import { useForm, router } from '@inertiajs/vue3'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, {}, () => page),
})

const props = defineProps<{
    categories: Array<Record<string, any>>
}>()

const createForm = useForm({
    name: '',
    description: '',
    image: null as File | null,
    sort_order: 0,
    is_active: true,
})

function createCategory() {
    createForm.post('/admin/categorias-menu', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => createForm.reset(),
    })
}

function updateCategory(category: any) {
    const form = useForm({
        name: category.name ?? '',
        description: category.description ?? '',
        image: null as File | null,
        sort_order: category.sort_order ?? 0,
        is_active: category.is_active ?? true,
    })

    form.post(`/admin/categorias-menu/${category.id}`, {
        forceFormData: true,
        preserveScroll: true,
    })
}

function destroyCategory(id: number) {
    router.delete(`/admin/categorias-menu/${id}`, {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="grid gap-6 xl:grid-cols-[430px_1fr]">
        <form @submit.prevent="createCategory" class="space-y-4 rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl">
            <h2 class="text-xl font-semibold text-white">Nueva categoría</h2>
            <input v-model="createForm.name" placeholder="Nombre" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <textarea v-model="createForm.description" rows="4" placeholder="Descripción" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <input v-model="createForm.sort_order" type="number" placeholder="Orden" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                <input v-model="createForm.is_active" type="checkbox" />
                Activa
            </label>
            <ImageUploader @selected="createForm.image = $event" />
            <button class="w-full rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-black">Guardar categoría</button>
        </form>

        <div class="grid gap-5 md:grid-cols-2">
            <div v-for="category in categories" :key="category.id" class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl">
                <ImageUploader :preview="category.image_url" @selected="category.image = $event" />
                <div class="mt-4 grid gap-3">
                    <input v-model="category.name" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <textarea v-model="category.description" rows="4" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <input v-model="category.sort_order" type="number" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                        <input v-model="category.is_active" type="checkbox" />
                        Activa
                    </label>

                    <div class="grid grid-cols-2 gap-3">
                        <button @click="updateCategory(category)" type="button" class="rounded-2xl bg-emerald-500 px-4 py-3 font-semibold text-white">
                            Guardar
                        </button>
                        <button @click="destroyCategory(category.id)" type="button" class="rounded-2xl bg-rose-500 px-4 py-3 font-semibold text-white">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
