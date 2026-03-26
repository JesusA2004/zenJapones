<script setup lang="ts">
import SectionTitle from '@/components/Public/SectionTitle.vue'
</script>

<template>
    <section class="border-b border-white/10 bg-neutral-950">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-20 md:grid-cols-2 md:px-6">
            <div class="flex items-center">
                <SectionTitle
                    eyebrow="Concepto"
                    title="Una experiencia japonesa elegante, actual y memorable."
                    description="Zen Japonés combina cocina, atmósfera y servicio en un entorno pensado para disfrutar cada visita con identidad propia."
                />
            </div>

            <div class="rounded-3xl border border-white/10 bg-neutral-900 p-8">
                <p class="text-base leading-8 text-neutral-300">
                    Nuestro enfoque está en cuidar cada detalle: ingredientes, presentación, ambiente y consistencia.
                    El sitio web debe comunicar esa misma experiencia con una imagen sobria, atractiva y fácil de navegar.
                </p>

                <div class="mt-8 grid grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-white/10 bg-black/40 p-5">
                        <p class="text-3xl font-bold text-amber-400">2</p>
                        <p class="mt-2 text-sm text-neutral-300">Sucursales destacadas</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/40 p-5">
                        <p class="text-3xl font-bold text-amber-400">100%</p>
                        <p class="mt-2 text-sm text-neutral-300">Menú administrable</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
