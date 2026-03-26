<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import ImageUploader from '@/components/Admin/ImageUploader.vue'
import { useForm, router } from '@inertiajs/vue3'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, {}, () => page),
})

const props = defineProps<{
    slides: Array<Record<string, any>>
}>()

const createForm = useForm({
    title: '',
    subtitle: '',
    image: null as File | null,
    cta_text: '',
    cta_url: '',
    sort_order: 0,
    is_active: true,
})

function createSlide() {
    createForm.post('/admin/hero-slides', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => createForm.reset(),
    })
}

function updateSlide(slide: any) {
    const form = useForm({
        title: slide.title ?? '',
        subtitle: slide.subtitle ?? '',
        image: null as File | null,
        cta_text: slide.cta_text ?? '',
        cta_url: slide.cta_url ?? '',
        sort_order: slide.sort_order ?? 0,
        is_active: slide.is_active ?? true,
    })

    form.post(`/admin/hero-slides/${slide.id}`, {
        forceFormData: true,
        preserveScroll: true,
    })
}

function destroySlide(id: number) {
    router.delete(`/admin/hero-slides/${id}`, {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="space-y-6">
        <div class="grid gap-6 xl:grid-cols-[420px_1fr]">
            <form @submit.prevent="createSlide" class="space-y-4 rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl">
                <h2 class="text-xl font-semibold text-white">Nuevo slide</h2>

                <input v-model="createForm.title" placeholder="Título" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <textarea v-model="createForm.subtitle" rows="3" placeholder="Subtítulo" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="createForm.cta_text" placeholder="Texto botón" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="createForm.cta_url" placeholder="URL botón" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="createForm.sort_order" type="number" placeholder="Orden" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />

                <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                    <input v-model="createForm.is_active" type="checkbox" />
                    Activo
                </label>

                <ImageUploader @selected="createForm.image = $event" />

                <button class="w-full rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-black">Guardar slide</button>
            </form>

            <div class="grid gap-5 md:grid-cols-2 2xl:grid-cols-3">
                <div v-for="slide in slides" :key="slide.id" class="overflow-hidden rounded-3xl border border-white/10 bg-white/5 shadow-xl">
                    <img v-if="slide.image_url" :src="slide.image_url" :alt="slide.title" class="h-52 w-full object-cover" />
                    <div class="space-y-3 p-4">
                        <input v-model="slide.title" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                        <textarea v-model="slide.subtitle" rows="2" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                        <input v-model="slide.cta_text" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                        <input v-model="slide.cta_url" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                        <input v-model="slide.sort_order" type="number" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />

                        <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                            <input v-model="slide.is_active" type="checkbox" />
                            Activo
                        </label>

                        <ImageUploader :preview="slide.image_url" @selected="slide.image = $event" />

                        <div class="grid grid-cols-2 gap-3">
                            <button @click="updateSlide(slide)" type="button" class="rounded-2xl bg-emerald-500 px-4 py-3 font-semibold text-white">
                                Actualizar
                            </button>
                            <button @click="destroySlide(slide.id)" type="button" class="rounded-2xl bg-rose-500 px-4 py-3 font-semibold text-white">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
