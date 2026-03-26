<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import PublicLayout from '@/layouts/PublicLayout.vue'
import SectionTitle from '@/components/Public/SectionTitle.vue'

defineOptions({ layout: PublicLayout })
</script>

<template>
    <Head title="Aviso de privacidad" />

    <section class="bg-black">
        <div class="mx-auto max-w-4xl px-4 py-20 md:px-6">
            <SectionTitle eyebrow="Legal"
                title="Aviso de privacidad"
                description="Aquí podrás colocar el contenido legal del restaurante en una página separada y más ordenada."/>

            <div class="mt-10 rounded-3xl border border-white/10 bg-neutral-950 p-8 text-sm leading-8 text-neutral-300">
                Este sitio recopila la información estrictamente necesaria para fines de contacto, reservaciones,
                facturación y atención al cliente. El tratamiento de datos deberá ajustarse a la normatividad aplicable
                y a las políticas internas del restaurante.
            </div>
        </div>
    </section>
</template>
