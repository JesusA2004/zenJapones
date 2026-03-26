<script setup lang="ts">
import SectionTitle from '@/components/Public/SectionTitle.vue'
</script>

<template>
    <section class="border-b border-white/10 bg-black">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-20 md:grid-cols-2 md:px-6">
            <div class="overflow-hidden rounded-3xl border border-white/10">
                <img
                    src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?auto=format&fit=crop&w=1400&q=80"
                    alt="Experiencia Zen Japonés"
                    class="h-full min-h-[420px] w-full object-cover"
                />
            </div>

            <div class="flex items-center">
                <div>
                    <SectionTitle
                        eyebrow="Experiencia"
                        title="Más que un menú, una experiencia de marca."
                        description="El nuevo sitio debe conservar la esencia visual del actual, pero con una estructura moderna, escalable y lista para cambios frecuentes."
                    />

                    <div class="mt-8 space-y-4">
                        <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                            <h3 class="text-lg font-semibold text-white">Diseño premium</h3>
                            <p class="mt-2 text-sm leading-7 text-neutral-300">
                                Estilo sobrio, elegante y adaptable a móvil.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                            <h3 class="text-lg font-semibold text-white">Contenido modular</h3>
                            <p class="mt-2 text-sm leading-7 text-neutral-300">
                                Componentes reutilizables para home, menú, sucursales y eventos.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-neutral-950 p-5">
                            <h3 class="text-lg font-semibold text-white">Control administrativo</h3>
                            <p class="mt-2 text-sm leading-7 text-neutral-300">
                                Gestión de imágenes, textos, precios, categorías y publicaciones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
