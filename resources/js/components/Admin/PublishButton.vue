<script setup lang="ts">
import { router, useForm } from '@inertiajs/vue3'

defineProps<{
    version: number
}>()

const form = useForm({
    notes: '',
})

function publish() {
    form.post('/admin/publish-menu', {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="rounded-3xl border border-amber-400/20 bg-gradient-to-r from-amber-400/10 via-amber-300/5 to-transparent p-5 shadow-xl sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-amber-400">Publicación</p>
                <h3 class="mt-2 text-2xl font-semibold text-white">Versión actual del menú: v{{ version }}</h3>
                <p class="mt-2 text-sm text-white/70">
                    Al publicar, se incrementa la versión para forzar que el frontend descargue la versión más reciente.
                </p>
            </div>

            <div class="w-full max-w-md space-y-3">
                <textarea
                    v-model="form.notes"
                    rows="3"
                    placeholder="Notas de publicación..."
                    class="w-full rounded-2xl border border-white/10 bg-black px-4 py-3 text-sm text-white outline-none ring-0 transition focus:border-amber-400"
                />
                <button
                    type="button"
                    @click="publish"
                    class="w-full rounded-2xl bg-amber-400 px-5 py-3 text-sm font-semibold text-black shadow-lg transition hover:-translate-y-0.5 hover:shadow-amber-400/30"
                >
                    Publicar cambios
                </button>
            </div>
        </div>
    </div>
</template>
