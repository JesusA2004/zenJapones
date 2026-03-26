<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'

interface Item {
    label: string
    href: string
}

defineProps<{
    items: Item[]
}>()

const page = usePage()

const isActive = (href: string) => page.url === href
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-white/10 bg-black/85 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 md:px-6">
            <Link href="/" class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-amber-400 text-black font-bold">
                    禅
                </div>
                <div>
                    <p class="text-lg font-semibold tracking-[0.18em] text-white">ZEN JAPONÉS</p>
                    <p class="text-xs uppercase tracking-[0.25em] text-neutral-400">Cocina & experiencia</p>
                </div>
            </Link>

            <nav class="hidden items-center gap-6 md:flex">
                <Link
                    v-for="item in items"
                    :key="item.href"
                    :href="item.href"
                    class="text-sm font-medium transition"
                    :class="isActive(item.href) ? 'text-amber-400' : 'text-neutral-200 hover:text-amber-400'"
                >
                    {{ item.label }}
                </Link>
            </nav>
        </div>
    </header>
</template>
