<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, { title: 'Eventos' }, () => page),
})

const events = [
    { title: 'Noche de sake', date: '2026-04-10', status: 'Publicado' },
    { title: 'Cena temática', date: '2026-04-18', status: 'Borrador' },
]
</script>

<template>
    <div class="rounded-2xl border border-neutral-800 bg-neutral-900 p-6">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white">Gestión de eventos</h2>
            <button class="rounded-xl bg-amber-400 px-4 py-2 text-sm font-semibold text-black">
                Nuevo evento
            </button>
        </div>

        <div class="grid gap-4">
            <div
                v-for="event in events"
                :key="event.title"
                class="rounded-2xl border border-neutral-800 bg-black/40 p-5"
            >
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-white">{{ event.title }}</h3>
                        <p class="mt-1 text-sm text-neutral-400">{{ event.date }}</p>
                    </div>

                    <span
                        class="rounded-full px-3 py-1 text-xs"
                        :class="event.status === 'Publicado'
                            ? 'bg-emerald-500/15 text-emerald-400'
                            : 'bg-amber-400/15 text-amber-400'"
                    >
                        {{ event.status }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
