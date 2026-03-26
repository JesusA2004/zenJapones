<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import SectionTitle from '@/components/Public/SectionTitle.vue'

defineOptions({ layout: PublicLayout })
</script>

<template>
    <Head title="Bolsa de trabajo" />

    <section class="bg-neutral-950">
        <div class="mx-auto max-w-4xl px-4 py-20 md:px-6">
            <SectionTitle
                eyebrow="Talento"
                title="Bolsa de trabajo"
                description="Sección independiente para vacantes, captación de talento o contacto de recursos humanos."
            />

            <div class="mt-10 rounded-3xl border border-white/10 bg-black p-8">
                <h3 class="text-xl font-semibold text-white">Únete a nuestro equipo</h3>
                <p class="mt-4 text-sm leading-7 text-neutral-300">
                    Comparte tu información y experiencia para formar parte del equipo de Zen Japonés.
                </p>

                <div class="mt-6 rounded-2xl border border-white/10 bg-neutral-950 p-5 text-sm text-neutral-300">
                    Correo sugerido: <span class="font-semibold text-white">rh@zenjapones.com</span>
                </div>
            </div>
        </div>
    </section>
</template>
