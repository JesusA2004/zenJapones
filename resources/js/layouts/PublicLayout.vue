<script setup lang="ts">
import PublicNavbar from '@/components/Public/PublicNavbar.vue'
</script>

<template>
    <div class="min-h-screen w-full overflow-x-hidden bg-black text-white">
        <PublicNavbar />
        <main class="w-full overflow-x-hidden">
            <slot />
        </main>
    </div>
</template>
