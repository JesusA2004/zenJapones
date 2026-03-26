<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'

defineOptions({ layout: PublicLayout })
</script>

<template>
    <Head title="Sucursales" />

    <section class="relative bg-black">
        <img
            src="/images/decor/bg-city.webp"
            alt="Fondo ciudad"
            class="absolute inset-0 h-full w-full object-cover opacity-20"
        />

        <div class="relative z-10 mx-auto max-w-7xl space-y-16 px-4 py-20 md:px-6">
            <article class="rounded-3xl border border-white/10 bg-black/70 p-6 md:p-8">
                <h1 class="mb-6 text-center text-4xl font-semibold tracking-[0.18em] text-white">TEPOZTLÁN</h1>

                <div class="overflow-hidden rounded-2xl border border-white/10">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1886.3944154015321!2d-99.0999183!3d18.9849312!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce0d1a09b1733f%3A0x61ad89996758f62e!2sZen%20Japon%C3%A9s!5e0!3m2!1ses-419!2smx!4v1753733690908!5m2!1ses-419!2smx"
                        width="600"
                        height="450"
                        style="border: 0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="h-[420px] w-full"
                    ></iframe>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                        <h3 class="text-sm font-semibold tracking-[0.2em] text-amber-400">TELÉFONO</h3>
                        <p class="mt-3 text-white">+52 777 903 9115</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                        <h3 class="text-sm font-semibold tracking-[0.2em] text-amber-400">DIRECCIÓN</h3>
                        <p class="mt-3 text-white/90">
                            Arq. Pablo Gonzaléz #1, Plaza Clarita, Barrio La Santisima, Tepoztlán, Morelos.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                        <h3 class="text-sm font-semibold tracking-[0.2em] text-amber-400">HORARIO</h3>
                        <div class="mt-3 space-y-1 text-white/90">
                            <p>Lunes, Miercoles, Jueves: 12:00 - 20:00</p>
                            <p>Martes: CERRADO</p>
                            <p>Viernes: 12:00 - 21:00</p>
                            <p>Sabado: 11:00 - 21:00</p>
                            <p>Domingo: 11:00 - 20:00</p>
                        </div>
                    </div>
                </div>
            </article>

            <article class="rounded-3xl border border-white/10 bg-black/70 p-6 md:p-8">
                <h2 class="mb-6 text-center text-4xl font-semibold tracking-[0.18em] text-white">CUERNAVACA</h2>

                <div class="overflow-hidden rounded-2xl border border-white/10">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3774.5547879993946!2d-99.21871379999999!3d18.906822199999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cddf80ee62ad17%3A0x66a951efc3b6276e!2sZen%20Japon%C3%A9s!5e0!3m2!1ses-419!2smx!4v1765407658545!5m2!1ses-419!2smx"
                        width="600"
                        height="450"
                        style="border: 0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="h-[420px] w-full"
                    ></iframe>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                        <h3 class="text-sm font-semibold tracking-[0.2em] text-amber-400">TELÉFONO</h3>
                        <p class="mt-3 text-white">+52 777 153 1475</p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                        <h3 class="text-sm font-semibold tracking-[0.2em] text-amber-400">DIRECCIÓN</h3>
                        <p class="mt-3 text-white/90">
                            Av. Adolfo Ruiz Cortines #17, Acapantzingo, C.P. 62440. Cuernavaca, Mor.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                        <h3 class="text-sm font-semibold tracking-[0.2em] text-amber-400">HORARIO</h3>
                        <p class="mt-3 text-white/90">Lunes a Domingo: 13:00 - 22:00.</p>
                    </div>
                </div>
            </article>
        </div>
    </section>
</template>
