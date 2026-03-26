<script setup lang="ts">
const emit = defineEmits<{
    (e: 'selected', file: File | null): void
}>()

function onChange(event: Event) {
    const target = event.target as HTMLInputElement
    const file = target.files?.[0] ?? null
    emit('selected', file)
}
</script>

<template>
    <div class="rounded-2xl border border-dashed border-neutral-700 bg-neutral-950 p-6">
        <label class="block cursor-pointer">
            <span class="mb-3 block text-sm font-medium text-white">Subir imagen</span>
            <input type="file" accept="image/*" class="block w-full text-sm text-neutral-300" @change="onChange" />
        </label>

        <p class="mt-3 text-xs leading-6 text-neutral-500">
            Recomendación: usar nombres únicos o versionados para evitar que se muestre una imagen vieja en caché.
        </p>
    </div>
</template>
