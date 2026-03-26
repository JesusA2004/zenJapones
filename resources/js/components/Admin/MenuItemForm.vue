<script setup lang="ts">
defineProps<{
    version?: string | number
}>()

const emit = defineEmits<{
    (e: 'publish'): void
}>()
</script>

<template>
    <div class="rounded-2xl border border-amber-400/30 bg-amber-400/10 p-5">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-amber-400">Publicación</p>
                <h3 class="mt-2 text-lg font-semibold text-white">
                    Versión actual del menú: {{ version ?? 'Borrador' }}
                </h3>
                <p class="mt-2 text-sm leading-7 text-neutral-300">
                    Al publicar, incrementa la versión del menú para ayudar a que el frontend descargue la información más reciente.
                </p>
            </div>

            <button
                type="button"
                @click="$emit('publish')"
                class="rounded-xl bg-amber-400 px-5 py-3 text-sm font-semibold text-black transition hover:scale-[1.02]"
            >
                Publicar cambios
            </button>
        </div>
    </div>
</template>
