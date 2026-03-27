<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-zinc-950 text-zinc-100">
            <div class="mx-auto w-full max-w-[1800px] px-3 py-4 sm:px-4 md:px-6 xl:px-8 2xl:px-10">
                <section class="min-w-0 space-y-6">
                    <slot />
                </section>
            </div>
        </div>
    </AppLayout>
</template>
