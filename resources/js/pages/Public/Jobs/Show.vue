<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })

interface BannerData {
    key: string
    title: string
    subtitle?: string | null
    content?: string | null
    image_path?: string | null
}

defineProps<{
    content?: string | null
    banner: BannerData | null
}>()
</script>

<template>
    <Head title="Bolsa de trabajo" />

    <section class="bg-black">
        <div class="relative">
            <img
                v-if="banner?.image_path"
                :src="banner.image_path"
                :alt="banner.title"
                class="h-[320px] w-full object-cover opacity-80"
            />

            <div class="absolute bottom-4 left-4">
                <a
                    href="/"
                    class="inline-flex rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-black"
                >
                    CONTÁCTANOS
                </a>
            </div>
        </div>

        <div class="mx-auto max-w-3xl px-4 py-16 md:px-6">
            <h1 class="mb-8 text-center text-4xl font-semibold tracking-[0.18em] text-white">
                BOLSA DE TRABAJO
            </h1>

            <div v-if="content" class="mb-8 whitespace-pre-line rounded-3xl border border-white/10 bg-neutral-950 p-8 text-sm leading-8 text-white/90">
                {{ content }}
            </div>

            <form class="space-y-5 rounded-3xl border border-white/10 bg-neutral-950 p-8">
                <div>
                    <label class="mb-2 block text-sm font-medium text-white">Nombre y apellidos</label>
                    <input type="text" class="w-full rounded-xl border border-white/10 bg-black px-4 py-3 text-white outline-none" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white">Fecha de nacimiento</label>
                    <input type="date" class="w-full rounded-xl border border-white/10 bg-black px-4 py-3 text-white outline-none" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white">Teléfono</label>
                    <input type="tel" class="w-full rounded-xl border border-white/10 bg-black px-4 py-3 text-white outline-none" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white">Correo</label>
                    <input type="email" class="w-full rounded-xl border border-white/10 bg-black px-4 py-3 text-white outline-none" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white">Vacante</label>
                    <input type="text" class="w-full rounded-xl border border-white/10 bg-black px-4 py-3 text-white outline-none" />
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-white">Adjunta tu CV</label>
                    <input type="file" class="w-full rounded-xl border border-white/10 bg-black px-4 py-3 text-white outline-none" accept="application/pdf" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-black">
                        POSTÚLATE
                    </button>
                </div>
            </form>
        </div>
    </section>
</template>
