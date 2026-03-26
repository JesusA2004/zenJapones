<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const items = [
    { label: 'Dashboard', href: '/admin' },
    { label: 'Ajustes', href: '/admin/settings' },
    { label: 'Hero Slides', href: '/admin/hero-slides' },
    { label: 'Secciones', href: '/admin/content-sections' },
    { label: 'Sucursales', href: '/admin/sucursales' },
    { label: 'Eventos', href: '/admin/eventos' },
    { label: 'Categorías', href: '/admin/categorias-menu' },
    { label: 'Platillos', href: '/admin/menu-items' },
]

const isActive = (href: string) => page.url === href
</script>

<template>
    <AuthLayout>
        <div class="min-h-screen bg-neutral-950 text-white">
            <div class="mx-auto grid max-w-[1800px] gap-6 px-3 py-4 sm:px-4 md:px-6 lg:grid-cols-[280px_1fr] xl:gap-8 xl:px-8 2xl:px-10">
                <aside class="rounded-3xl border border-white/10 bg-white/5 p-4 shadow-2xl backdrop-blur sm:p-5">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-400 text-lg font-bold text-black shadow-lg">
                            禅
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-amber-400">Panel</p>
                            <h1 class="text-lg font-semibold text-white">Zen Japonés</h1>
                        </div>
                    </div>

                    <nav class="grid gap-2">
                        <Link
                            v-for="item in items"
                            :key="item.href"
                            :href="item.href"
                            class="group rounded-2xl px-4 py-3 text-sm font-medium transition-all duration-200"
                            :class="isActive(item.href)
                                ? 'bg-amber-400 text-black shadow-lg shadow-amber-400/20'
                                : 'bg-white/5 text-white hover:bg-white/10 hover:translate-x-1'"
                        >
                            {{ item.label }}
                        </Link>
                    </nav>
                </aside>

                <section class="min-w-0 space-y-6">
                    <slot />
                </section>
            </div>
        </div>
    </AuthLayout>
</template>
