<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })
</script>

<template>
    <Head title="Menú" />

    <section class="min-h-[70vh] bg-black px-4 py-20 md:px-6">
        <div class="mx-auto max-w-7xl">
            <div class="rounded-3xl border border-white/10 bg-neutral-950 p-8">
                <h1 class="text-4xl font-semibold tracking-[0.18em] text-white">MENÚ</h1>
                <p class="mt-4 max-w-2xl text-white/80">
                    Aquí irá la galería o listado dinámico del menú. El HTML original deja esta sección como contenedor para llenarse con JavaScript, así que aquí es donde luego conectaremos tus categorías, productos, imágenes y precios desde el panel. :contentReference[oaicite:1]{index=1}
                </p>

                <div class="mt-10 rounded-2xl border border-dashed border-white/15 p-10 text-center text-white/50">
                    Galería del menú pendiente de conectar con la base de datos
                </div>
            </div>
        </div>
    </section>
</template>
