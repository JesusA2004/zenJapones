<script setup lang="ts">
import { computed, ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import SectionTitle from '@/components/Public/SectionTitle.vue'

defineOptions({ layout: PublicLayout })

const activeCategory = ref('Todos')

const categories = ['Todos', 'Ramen', 'Sushi', 'Entradas', 'Bebidas']

const items = [
    { name: 'Ramen Tonkotsu', category: 'Ramen', price: '$210', description: 'Caldo intenso y textura equilibrada.' },
    { name: 'Ramen Picante', category: 'Ramen', price: '$220', description: 'Perfil especiado y gran presencia visual.' },
    { name: 'Roll Zen', category: 'Sushi', price: '$185', description: 'Un rollo distintivo con buen balance.' },
    { name: 'Gyozas', category: 'Entradas', price: '$120', description: 'Entrada ideal para compartir.' },
    { name: 'Matcha Tonic', category: 'Bebidas', price: '$95', description: 'Bebida fresca con identidad.' },
]

const filteredItems = computed(() => {
    if (activeCategory.value === 'Todos') return items
    return items.filter(item => item.category === activeCategory.value)
})
</script>

<template>
    <Head title="Menú" />

    <section class="bg-black">
        <div class="mx-auto max-w-7xl px-4 py-20 md:px-6">
            <SectionTitle
                eyebrow="Menú"
                title="Menú digital mejorado"
                description="Preparado para usar categorías, imágenes, disponibilidad y publicación versionada para evitar datos viejos."
            />

            <div class="mt-8 flex flex-wrap gap-3">
                <button
                    v-for="category in categories"
                    :key="category"
                    @click="activeCategory = category"
                    class="rounded-full border px-4 py-2 text-sm transition"
                    :class="activeCategory === category
                        ? 'border-amber-400 bg-amber-400 text-black'
                        : 'border-white/15 text-white hover:border-amber-400 hover:text-amber-400'"
                >
                    {{ category }}
                </button>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <article
                    v-for="item in filteredItems"
                    :key="item.name"
                    class="rounded-3xl border border-white/10 bg-neutral-950 p-6"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-amber-400">{{ item.category }}</p>
                            <h3 class="mt-2 text-xl font-semibold text-white">{{ item.name }}</h3>
                        </div>
                        <span class="text-lg font-bold text-amber-400">{{ item.price }}</span>
                    </div>

                    <p class="mt-4 text-sm leading-7 text-neutral-300">
                        {{ item.description }}
                    </p>
                </article>
            </div>

            <div class="mt-12 rounded-2xl border border-amber-400/20 bg-amber-400/10 p-5 text-sm text-neutral-200">
                Menú actualizado dinámicamente. Precios y disponibilidad sujetos a cambio sin previo aviso.
            </div>
        </div>
    </section>
</template>
