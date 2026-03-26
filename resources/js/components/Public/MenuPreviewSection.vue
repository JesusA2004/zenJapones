<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import SectionTitle from '@/components/Public/SectionTitle.vue'

interface MenuItem {
    name: string
    description: string
    price: string
    image: string
    badge?: string
}

defineProps<{
    items: MenuItem[]
}>()
</script>

<template>
    <section class="border-b border-white/10 bg-black">
        <div class="mx-auto max-w-7xl px-4 py-20 md:px-6">
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <SectionTitle
                    eyebrow="Menú"
                    title="Platillos destacados"
                    description="Vista previa del menú con estructura preparada para precios, imágenes, categorías y disponibilidad."
                />

                <Link
                    href="/menu"
                    class="inline-flex rounded-full border border-amber-400 px-5 py-3 text-sm font-semibold text-amber-400 transition hover:bg-amber-400 hover:text-black"
                >
                    Ver menú completo
                </Link>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <article
                    v-for="item in items"
                    :key="item.name"
                    class="overflow-hidden rounded-3xl border border-white/10 bg-neutral-950"
                >
                    <img :src="item.image" :alt="item.name" class="h-64 w-full object-cover" />
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p v-if="item.badge" class="text-xs uppercase tracking-[0.25em] text-amber-400">
                                    {{ item.badge }}
                                </p>
                                <h3 class="mt-2 text-xl font-semibold text-white">{{ item.name }}</h3>
                            </div>
                            <span class="text-lg font-bold text-amber-400">{{ item.price }}</span>
                        </div>
                        <p class="mt-4 text-sm leading-7 text-neutral-300">
                            {{ item.description }}
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>
</template>
