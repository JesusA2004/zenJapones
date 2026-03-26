<script setup lang="ts">
interface Branch {
    name: string
    phone: string
    address: string
    hours: string
    image: string
    mapsUrl: string
}

defineProps<{
    branch: Branch
}>()
</script>

<template>
    <article class="overflow-hidden rounded-3xl border border-white/10 bg-neutral-950">
        <img :src="branch.image" :alt="branch.name" class="h-64 w-full object-cover" />

        <div class="p-6">
            <h3 class="text-2xl font-semibold text-white">{{ branch.name }}</h3>

            <div class="mt-4 space-y-3 text-sm text-neutral-300">
                <p><span class="font-semibold text-white">Tel:</span> {{ branch.phone }}</p>
                <p><span class="font-semibold text-white">Dirección:</span> {{ branch.address }}</p>
                <p><span class="font-semibold text-white">Horario:</span> {{ branch.hours }}</p>
            </div>

            <div class="mt-6">
                <a
                    :href="branch.mapsUrl"
                    target="_blank"
                    class="inline-flex rounded-full bg-amber-400 px-5 py-3 text-sm font-semibold text-black transition hover:scale-[1.02]"
                >
                    Cómo llegar
                </a>
            </div>
        </div>
    </article>
</template>
