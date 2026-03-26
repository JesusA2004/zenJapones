<script setup lang="ts">
import Navbar from '@/components/Public/Navbar.vue'
import Footer from '@/components/Public/Footer.vue'
</script>

<template>
    <div class="min-h-screen bg-black text-white">
        <Navbar />

        <main>
            <slot />
        </main>

        <Footer />
    </div>
</template>
