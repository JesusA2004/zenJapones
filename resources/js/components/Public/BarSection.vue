<script setup lang="ts">
import SectionTitle from '@/components/Public/SectionTitle.vue'
</script>

<template>
    <section class="border-b border-white/10 bg-neutral-950">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-20 md:grid-cols-2 md:px-6">
            <div>
                <SectionTitle
                    eyebrow="Bar"
                    title="Coctelería, ambiente y una propuesta visual más sólida."
                    description="La sección de bar puede mantenerse como parte del storytelling del sitio, reforzando la experiencia del restaurante."
                />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-3xl border border-white/10 bg-black/40 p-6">
                    <h3 class="text-lg font-semibold text-white">Imagen cuidada</h3>
                    <p class="mt-3 text-sm leading-7 text-neutral-300">
                        Fotografías grandes, contrastes sobrios y textos breves.
                    </p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-black/40 p-6">
                    <h3 class="text-lg font-semibold text-white">Mejor jerarquía</h3>
                    <p class="mt-3 text-sm leading-7 text-neutral-300">
                        Secciones más claras, limpias y fáciles de recorrer.
                    </p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-black/40 p-6">
                    <h3 class="text-lg font-semibold text-white">Responsive real</h3>
                    <p class="mt-3 text-sm leading-7 text-neutral-300">
                        Mejor uso en celular sin depender de una sola landing rígida.
                    </p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-black/40 p-6">
                    <h3 class="text-lg font-semibold text-white">Escalable</h3>
                    <p class="mt-3 text-sm leading-7 text-neutral-300">
                        Lista para crecer con nuevas secciones, promos y eventos.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
