<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import ImageUploader from '@/components/Admin/ImageUploader.vue'
import { useForm, router } from '@inertiajs/vue3'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, {}, () => page),
})

const props = defineProps<{
    events: Array<Record<string, any>>
}>()

const createForm = useForm({
    title: '',
    excerpt: '',
    description: '',
    location: '',
    cta_text: '',
    cta_url: '',
    start_at: '',
    end_at: '',
    image: null as File | null,
    sort_order: 0,
    is_published: true,
})

function createEvent() {
    createForm.post('/admin/eventos', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => createForm.reset(),
    })
}

function updateEvent(event: any) {
    const form = useForm({
        title: event.title ?? '',
        excerpt: event.excerpt ?? '',
        description: event.description ?? '',
        location: event.location ?? '',
        cta_text: event.cta_text ?? '',
        cta_url: event.cta_url ?? '',
        start_at: event.start_at ?? '',
        end_at: event.end_at ?? '',
        image: null as File | null,
        sort_order: event.sort_order ?? 0,
        is_published: event.is_published ?? true,
    })

    form.post(`/admin/eventos/${event.id}`, {
        forceFormData: true,
        preserveScroll: true,
    })
}

function destroyEvent(id: number) {
    router.delete(`/admin/eventos/${id}`, {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="grid gap-6 xl:grid-cols-[430px_1fr]">
        <form @submit.prevent="createEvent" class="space-y-4 rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl">
            <h2 class="text-xl font-semibold text-white">Nuevo evento</h2>
            <input v-model="createForm.title" placeholder="Título" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <input v-model="createForm.location" placeholder="Ubicación" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <textarea v-model="createForm.excerpt" rows="3" placeholder="Extracto" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <textarea v-model="createForm.description" rows="4" placeholder="Descripción" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <div class="grid gap-4 md:grid-cols-2">
                <input v-model="createForm.start_at" type="datetime-local" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="createForm.end_at" type="datetime-local" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <input v-model="createForm.cta_text" placeholder="Texto botón" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="createForm.cta_url" placeholder="URL botón" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            </div>
            <input v-model="createForm.sort_order" type="number" placeholder="Orden" class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
            <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                <input v-model="createForm.is_published" type="checkbox" />
                Publicado
            </label>
            <ImageUploader @selected="createForm.image = $event" />
            <button class="w-full rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-black">Guardar evento</button>
        </form>

        <div class="grid gap-5 md:grid-cols-2">
            <div v-for="event in events" :key="event.id" class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl">
                <ImageUploader :preview="event.image_url" @selected="event.image = $event" />
                <div class="mt-4 grid gap-3">
                    <input v-model="event.title" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <input v-model="event.location" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <textarea v-model="event.excerpt" rows="2" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <textarea v-model="event.description" rows="4" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    <div class="grid gap-4 md:grid-cols-2">
                        <input v-model="event.start_at" type="datetime-local" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                        <input v-model="event.end_at" type="datetime-local" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                    </div>
                    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                        <input v-model="event.is_published" type="checkbox" />
                        Publicado
                    </label>

                    <div class="grid grid-cols-2 gap-3">
                        <button @click="updateEvent(event)" type="button" class="rounded-2xl bg-emerald-500 px-4 py-3 font-semibold text-white">
                            Guardar
                        </button>
                        <button @click="destroyEvent(event.id)" type="button" class="rounded-2xl bg-rose-500 px-4 py-3 font-semibold text-white">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
