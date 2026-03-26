<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import AuthLayout from '@/layouts/AuthLayout.vue'

interface Props {
    title?: string
}

withDefaults(defineProps<Props>(), {
    title: 'Panel administrativo',
})
</script>

<template>
    <AuthLayout>
        <div class="space-y-6 p-4 md:p-6">
            <div class="rounded-2xl border border-neutral-800 bg-neutral-900/70 p-5 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.25em] text-amber-400">Administración</p>
                        <h1 class="mt-2 text-2xl font-semibold text-white">{{ title }}</h1>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <Link
                            href="/admin"
                            class="rounded-xl border border-neutral-700 px-4 py-2 text-sm text-neutral-200 transition hover:border-amber-400 hover:text-amber-400"
                        >
                            Dashboard
                        </Link>
                        <Link
                            href="/admin/sucursales"
                            class="rounded-xl border border-neutral-700 px-4 py-2 text-sm text-neutral-200 transition hover:border-amber-400 hover:text-amber-400"
                        >
                            Sucursales
                        </Link>
                        <Link
                            href="/admin/categorias-menu"
                            class="rounded-xl border border-neutral-700 px-4 py-2 text-sm text-neutral-200 transition hover:border-amber-400 hover:text-amber-400"
                        >
                            Categorías
                        </Link>
                        <Link
                            href="/admin/menu-items"
                            class="rounded-xl border border-neutral-700 px-4 py-2 text-sm text-neutral-200 transition hover:border-amber-400 hover:text-amber-400"
                        >
                            Menú
                        </Link>
                        <Link
                            href="/admin/eventos"
                            class="rounded-xl border border-neutral-700 px-4 py-2 text-sm text-neutral-200 transition hover:border-amber-400 hover:text-amber-400"
                        >
                            Eventos
                        </Link>
                        <Link
                            href="/admin/settings"
                            class="rounded-xl border border-neutral-700 px-4 py-2 text-sm text-neutral-200 transition hover:border-amber-400 hover:text-amber-400"
                        >
                            Configuración
                        </Link>
                    </div>
                </div>
            </div>

            <slot />
        </div>
    </AuthLayout>
</template>
