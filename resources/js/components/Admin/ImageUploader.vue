<script setup lang="ts">
const emit = defineEmits<{
    (e: 'selected', file: File | null): void
}>()

defineProps<{
    preview?: string | null
    label?: string
}>()

function onChange(event: Event) {
    const target = event.target as HTMLInputElement
    emit('selected', target.files?.[0] ?? null)
}
</script>

<template>
    <div class="space-y-3">
        <label class="block text-sm font-medium text-white">{{ label || 'Imagen' }}</label>

        <div class="overflow-hidden rounded-2xl border border-dashed border-white/15 bg-white/5">
            <div v-if="preview" class="border-b border-white/10">
                <img :src="preview" alt="Preview" class="h-48 w-full object-cover" />
            </div>

            <div class="p-4">
                <input
                    type="file"
                    accept="image/*"
                    class="block w-full rounded-xl border border-white/10 bg-black px-4 py-3 text-sm text-white file:mr-4 file:rounded-xl file:border-0 file:bg-amber-400 file:px-4 file:py-2 file:font-semibold file:text-black"
                    @change="onChange"
                />
            </div>
        </div>
    </div>
</template>
