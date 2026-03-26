<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import ImageUploader from '@/components/Admin/ImageUploader.vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, {}, () => page),
})

const props = defineProps<{
    sections: Array<Record<string, any>>
}>()

const labels: Record<string, string> = {
    home_concept: 'Concepto',
    home_experience: 'Experiencia',
    home_bar: 'Bar',
    home_menu_cta: 'CTA Menú',
    events_banner: 'Banner Eventos',
    jobs_banner: 'Banner Bolsa de trabajo',
    privacy_banner: 'Banner Aviso de privacidad',
}

function updateSection(section: any) {
    const form = useForm({
        title: section.title ?? '',
        subtitle: section.subtitle ?? '',
        content: section.content ?? '',
        image: null as File | null,
        button_text: section.extra_json?.button_text ?? '',
        button_url: section.extra_json?.button_url ?? '',
        sort_order: section.sort_order ?? 0,
        is_active: section.is_active ?? true,
    })

    form.post(`/admin/content-sections/${section.id}`, {
        forceFormData: true,
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="grid gap-6 xl:grid-cols-2">
        <div
            v-for="section in sections"
            :key="section.id"
            class="rounded-3xl border border-white/10 bg-white/5 p-5 shadow-xl"
        >
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-amber-400">{{ section.key }}</p>
                    <h2 class="mt-1 text-xl font-semibold text-white">{{ labels[section.key] || section.key }}</h2>
                </div>
                <span class="rounded-full px-3 py-1 text-xs" :class="section.is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-white/10 text-white/60'">
                    {{ section.is_active ? 'Activa' : 'Inactiva' }}
                </span>
            </div>

            <div class="grid gap-4">
                <input v-model="section.title" placeholder="Título" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="section.subtitle" placeholder="Subtítulo" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <textarea v-model="section.content" rows="5" placeholder="Contenido" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="section.extra_json.button_text" placeholder="Texto botón" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="section.extra_json.button_url" placeholder="URL botón" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />
                <input v-model="section.sort_order" type="number" placeholder="Orden" class="rounded-2xl border border-white/10 bg-black px-4 py-3 text-white" />

                <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black px-4 py-3 text-white">
                    <input v-model="section.is_active" type="checkbox" />
                    Activa
                </label>

                <ImageUploader :preview="section.image_url" @selected="section.image = $event" />

                <button @click="updateSection(section)" type="button" class="rounded-2xl bg-amber-400 px-5 py-3 font-semibold text-black">
                    Guardar sección
                </button>
            </div>
        </div>
    </div>
</template>
